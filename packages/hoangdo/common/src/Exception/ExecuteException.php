<?php

namespace HoangDo\Common\Exception;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class ExecuteException extends Exception implements HttpExceptionInterface
{
    public function __construct($message = "", $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode()
    {
        // TODO: Implement getStatusCode() method.
    }

    public function getHeaders()
    {
        // TODO: Implement getHeaders() method.
    }
}
