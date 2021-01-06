<?php

namespace App\Repositories\Contract;

use App\Models\ContactMessage;
use HoangDo\Common\Repository\Repository;

/**
 * Interface ContactMessageRepository.
 *
 * @package namespace App\Repositories\Contract;
 */
interface ContactMessageRepository extends Repository
{
    public function markAsNotified($id): ContactMessage;

    public function markAsRead($id): ContactMessage;

    public function updateStatus($id, $status): ContactMessage;
}
