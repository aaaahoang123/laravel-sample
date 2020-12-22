<?php


namespace HoangDo\Notification\Repository;

use HoangDo\Notification\Model\Notification;
use Prettus\Repository\Eloquent\BaseRepository;

class NotificationRepositoryEloquent extends BaseRepository implements NotificationRepository
{

    public function model()
    {
        return Notification::class;
    }

    public function boot()
    {

    }

    public function save($object)
    {
        $is_created = !$object->getKey();
        $object->save();
        if ($is_created) {
            $object->refresh();
        }
        return $object;
    }

    public function insertMany(array $data)
    {
        return $this->model->newQuery()->insert($data);
    }

    public function listNotifiesOfUser($limit, $user_id)
    {
        return $this->model->newQuery()
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->paginate($limit);
    }
}
