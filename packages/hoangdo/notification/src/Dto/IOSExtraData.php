<?php


namespace HoangDo\Notification\Dto;


use HoangDo\Notification\Model\Notification;

class IOSExtraData
{
    public $title;
    public $body;
    public $badge;
    public $mutable_content;
    public $sound;

    /**
     * IOSExtraData constructor.
     * @param Notification $notification
     */
    public function __construct($notification = null)
    {
        $this->mutable_content = true;
        $this->sound = 'default';
        $this->badge = 1;

        if ($notification) {
            $this->title = $notification->title;
            $this->body = $notification->description;
        }
    }
}
