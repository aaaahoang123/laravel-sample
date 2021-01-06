<?php

namespace App\Repositories\Eloquent;

use HoangDo\Common\Repository\RepositoryEloquent;
use App\Repositories\Contract\ContactMessageRepository;
use App\Models\ContactMessage;

/**
 * Class ContactMessageRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class ContactMessageRepositoryEloquent extends RepositoryEloquent implements ContactMessageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ContactMessage::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
//        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function markAsNotified($id): ContactMessage
    {
        /** @var ContactMessage $message */
        $message = $this->find($id);
        $message->notified = true;
        return $this->save($message);
    }

    public function markAsRead($id): ContactMessage
    {
        /** @var ContactMessage $message */
        $message = $this->find($id);
        $message->read = true;
        return $this->save($message);
    }

    public function updateStatus($id, $status): ContactMessage
    {
        /** @var ContactMessage $message */
        $message = $this->find($id);
        $message->status = $status;
        return $this->save($message);
    }

}
