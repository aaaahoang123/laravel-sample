<?php


namespace HoangDo\Notification\Exception;


use Exception;
use Throwable;

class NotificationFailedException extends Exception
{
    public function __construct($message = "", $code = 404, Throwable $previous = null)
    {
        $message = $message ?: __('Không thể gửi notification');
        parent::__construct($message, $code, $previous);
    }
}
