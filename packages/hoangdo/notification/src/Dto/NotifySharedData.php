<?php


namespace HoangDo\Notification\Dto;

use HoangDo\Notification\Enum\NotificationType;
use HoangDo\Notification\Model\Notification;

class NotifySharedData
{
    public $id;
    public $name;
    public $message;
    public $status;
    public $click_action;
    public $type;
    public $room;
    public $content;

    /**
     * NotifySharedData constructor.
     * @param Notification $notification
     */
    public function __construct($notification = null)
    {
        $this->status = 1;
        $this->click_action = 'FLUTTER_NOTIFICATION_CLICK';
        $this->type = NotificationType::BASIC;
        if ($notification) {
            $this->type = $notification->type;
            $this->name = $notification->title;
            $this->message = $notification->description;
            $this->id = $notification->id ?: 0;
            switch ($notification->type) {
//                case NotificationOptions::TYPE_COMMENT:
//                case NotificationOptions::TYPE_STREAM:
//                    $this->room = $notification->content;
//                    break;
                case NotificationType::BASIC:
                    break;
                default:
                    $this->content = $notification->content;
                    break;
            }
        }
    }
}
