<?php

namespace HoangDo\Notification\Repository;

use HoangDo\Common\Enum\CommonStatus;
use HoangDo\Notification\Model\NotifyToken;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class NotifyTokenRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class NotifyTokenRepositoryEloquent extends BaseRepository implements NotifyTokenRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return NotifyToken::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
//        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function findTokensByUserIdAndOrderByLastLog($user_id)
    {
        return $this->findTokensByUserIdsAndOrderByLastLog([$user_id]);
    }

    public function findTokensByUserIdsAndOrderByLastLog($user_ids) {
        return $this->model->newQuery()
            ->whereIn('user_id', $user_ids)
            ->orderBy('updated_at', 'asc')
            ->cursor();
    }

    public function findTokensOfActiveUsers()
    {
        return $this->model->newQuery()
            ->whereHas('user', function (Builder $q) {
                return $q->where('status', CommonStatus::ACTIVE);
            })
            ->cursor();
    }

    public function delete($id)
    {
        return $this->model->newQuery()->where('id', $id)->delete();
    }

    public function findByTokenAndUserId($app_token, $user_id)
    {
        return $this->model->newQuery()->where(compact('app_token', 'user_id'))->get();
    }

    public function removeByAppToken($app_token)
    {
        return $this->model
            ->newQuery()
            ->where('app_token', $app_token)
            ->delete();
    }

}
