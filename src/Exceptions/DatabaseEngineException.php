<?php

namespace CommonPHP\DatabaseEngine\Exceptions;

use Exception;
use Throwable;

class DatabaseEngineException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}