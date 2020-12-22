<?php


namespace HoangDo\Notification\Traits;


use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use HoangDo\Notification\Dto\IOSExtraData;
use HoangDo\Notification\Dto\NotifySharedData;
use HoangDo\Notification\Enum\OsOption;
use HoangDo\Notification\Model\Notification;
use HoangDo\Notification\Model\NotifyToken;
use HoangDo\Notification\Repository\NotifyTokenRepository;
use Illuminate\Database\Eloquent\Collection;

trait CanPushNotification
{
    private Client $_http_client;
    private NotifyTokenRepository $_tokenRepo;
    private string $_push_url = 'https://fcm.googleapis.com/fcm/send';

    protected function bootNotificationConfig() {
        $this->_http_client = new Client([
            RequestOptions::HEADERS => [
                'accept' => 'application/json',
                'Content-Type' => 'application/json',
                'authorization' => 'key='.config('notification.fcm_authorization')
            ]
        ]);
        $this->_tokenRepo = app(NotifyTokenRepository::class);
    }

    /**
     * @param string[]|array $tokens
     * @param NotifySharedData $shared_data
     * @param IOSExtraData $extra_data
     */
    public function pushNotificationByTokens($tokens, $shared_data, $extra_data = null)
    {
        $chunk_array = array_chunk($tokens, config('notification.limit_each_push'));

        foreach ($chunk_array as $device_tokens) {
            $data = [
                'registration_ids'=> $device_tokens,
                'data' => $shared_data
            ];

            if ($extra_data != null) {
                $data['notification'] = $extra_data;
            }
            $res = $this->_http_client->post($this->_push_url, ['json' => $data]);
        }
        return;
    }

    /**
     * @param NotifyToken[]|Collection $notify_tokens
     * @param NotifySharedData $shared_data
     * @param IOSExtraData $extra_data
     */
    public function pushNotificationByNotifyTokensObject($notify_tokens, $shared_data, $extra_data)
    {
        $default_tokens = [];
        $other_tokens = [];

        foreach ($notify_tokens as $notify_token) {
            $token = $notify_token->app_token;
            if ($notify_token->os == OSOption::DEFAULT_OS)
                $default_tokens[] = $token;
            else
                $other_tokens[] = $token;
        }

        $this->pushNotificationByTokens($default_tokens, $shared_data, $extra_data);
        $this->pushNotificationByTokens($other_tokens, $shared_data);
    }

    public function pushNotificationToUser($user_id, $shared_data, $extra_data)
    {
        $this->pushNotificationToUsers([$user_id], $shared_data, $extra_data);
    }

    /**
     * @param $user_ids
     * @param NotifySharedData|Notification $shared_data
     * @param IOSExtraData|null $extra_data
     * @return void
     */
    public function pushNotificationToUsers($user_ids, $shared_data, $extra_data = null)
    {
        if ($shared_data instanceof Notification) {
            $this->pushNotificationToUsers(
                $user_ids,
                new NotifySharedData($shared_data),
                new IOSExtraData($shared_data)
            );
            return;
        }
        $token_objects = in_array(config('notification.for_all_notification_id'), $user_ids)
            ? $this->_tokenRepo->findTokensOfActiveUsers()
            : $this->_tokenRepo->findTokensByUserIdsAndOrderByLastLog($user_ids);
        $this->pushNotificationByNotifyTokensObject($token_objects, $shared_data, $extra_data);
    }

    public function pushNotification($notification)
    {
        $this->pushNotificationToUser($notification->user_id, $notification, null);
    }
}
