<?php


namespace HoangDo\Notification\Service;


use Carbon\Carbon;
use DB;
use Exception;
use HoangDo\Notification\Enum\NotificationStatus;
use HoangDo\Notification\Enum\NotificationType;
use HoangDo\Notification\Enum\OsOption;
use HoangDo\Notification\Exception\NotificationFailedException;
use HoangDo\Notification\Model\Notification;
use HoangDo\Notification\Model\NotifyToken;
use HoangDo\Notification\Repository\NotificationRepository;
use HoangDo\Notification\Repository\NotifyTokenRepository;
use HoangDo\Notification\Traits\CanPushNotification;

class NotifyServiceImpl implements NotifyService
{
    use CanPushNotification;
    private NotifyTokenRepository $tokenRepo;
    private NotificationRepository $notificationRepo;

    public function __construct(
        NotifyTokenRepository $tokenRepo,
        NotificationRepository $notificationRepo
    )
    {
        $this->tokenRepo = $tokenRepo;
        $this->notificationRepo = $notificationRepo;
        $this->bootNotificationConfig();
    }

    public function storeTokenForUser($user_id, $token, $os = OSOption::DEFAULT_OS)
    {
        $os = $os ?? OsOption::DEFAULT_OS;
        if ($token) {
            $existed_tokens = $this->tokenRepo->findTokensByUserIdAndOrderByLastLog($user_id);
            $selected_token = null;
            foreach ($existed_tokens as $existed_token) {
                if ($existed_token->app_token == $token) {
                    $selected_token = $existed_token;
                    break;
                }
            }

            if (!$selected_token) {
                if (count($existed_tokens) >= config('notification.limit_each_user')) {
                    $selected_token = $existed_tokens->first();
                } else {
                    $selected_token = new NotifyToken();
                    $selected_token->user_id = $user_id;
                }
            }
            $selected_token->os = $os;
            $selected_token->app_token = $token;
            $selected_token->save();
            $selected_token->refresh();
            return $selected_token;
        }
        return null;
    }

    /**
     * @inheritDoc
     */
    public function createNotifiesAndPush($data)
    {
        $policy_id = $data->policy_id;
        $req_user_ids = $data->user_ids;

        if (!$policy_id && (!$req_user_ids || count($req_user_ids) < 1))
            throw new NotificationFailedException('Yêu cầu chọn nhóm gửi hoặc cá nhân gửi');

        $notification = new Notification($data->filteredData());

        if($req_user_ids) {
            $notification = $this->storeNotifications($req_user_ids, $notification);
            $this->pushNotificationToUsers($req_user_ids, $notification);
        } elseif ($policy_id == config('notification.for_all_notification_id')) {
            $notification->user_id = config('notification.for_all_notification_id');
            $notification = $this->storeNotification($notification);
            $this->pushNotification($notification);
        } elseif ($policy_id) {
            // TODO: Handle when policy_id is sent from client
        }

        return $notification;
    }
//
    public function storeNotification(Notification $notification, $will_push = true)
    {
        $notification->type = $notification->type ?? $this->getTypeByContent($notification->content);
        $notification = $this->notificationRepo->save($notification);
        if ($will_push) {
            $this->pushNotification($notification);
        }
        return $notification;
    }

    public function storeNotifications(array $user_ids, Notification $data, $will_push = true)
    {
        $created_at = $updated_at = Carbon::now();
        $type = $data->type ?? $this->getTypeByContent($data->content);
        $fillable_data = compact('created_at', 'updated_at', 'type') + $data->getAttributes();

        $chunked_user_ids = array_chunk($user_ids, config('notification.limit_each_push'));
        DB::beginTransaction();
        $inserted = true;
        try {
            foreach ($chunked_user_ids as $chunked_user_id) {
                $insert_data = collect($chunked_user_id)->map(fn($user_id) => compact('user_id') + $fillable_data)->toArray();
                if (!$this->notificationRepo->insertMany($insert_data)) $inserted = false;
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        $inserted ? DB::commit() : DB::rollBack();

        $data->setAttribute('type', $type);

        if ($inserted) {
            if ($will_push)
                $this->pushNotificationToUsers($user_ids, $data);
            return $data;
        }
        return null;
    }

    public function findOneAndReadNotification($user, $notification_id)
    {
        /** @var Notification $notification */
        $notification = $this->notificationRepo->find($notification_id);
        if (in_array($notification->user_id, [$user->id, config('notification.for_all_notification_id')])) {
            $notification->status = NotificationStatus::READ;
            $this->notificationRepo->save($notification);
        }
        return $notification;
    }

    public function listNotifications($limit, $user)
    {
        return $this->notificationRepo->listNotifiesOfUser($limit, $user->id);
    }

    private function getTypeByContent($content)
    {
        return filter_var($content, FILTER_VALIDATE_URL)
            ? NotificationType::LINK
            : NotificationType::BASIC;
    }

    public function removeAppToken($app_token)
    {
        return $this->tokenRepo->removeByAppToken($app_token);
    }
}
