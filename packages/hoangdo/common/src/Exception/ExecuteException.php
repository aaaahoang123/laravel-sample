<?php

namespace HoangDo\Common\Exception;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class ExecuteException extends Exception
{
    public function __construct($message = "", $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }


}
