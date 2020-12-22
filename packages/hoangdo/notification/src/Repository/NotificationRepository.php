<?php


namespace HoangDo\Notification\Repository;


use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

interface NotificationRepository extends RepositoryCriteriaInterface, RepositoryInterface
{
    /**
     * @param Model $object
     * @return Model
     */
    public function save($object);

    public function insertMany(array $data);

    public function listNotifiesOfUser($limit, $user_id);
}
