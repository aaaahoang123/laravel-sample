<?php


namespace HoangDo\Authorization\Exception;


use Exception;
use Throwable;

class AuthorizationException extends Exception
{
    public function __construct($message = "", $code = 403, Throwable $previous = null)
    {
        $message = $message ?: __('Bạn không có quyền truy cập tài nguyên này.');
        parent::__construct($message, $code, $previous);
    }
}
