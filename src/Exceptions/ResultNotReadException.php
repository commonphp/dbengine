<?php

namespace CommonPHP\DatabaseEngine\Exceptions;

use Throwable;

class ResultNotReadException extends DatabaseEngineException
{
    public function __construct(int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('You must call Result::Read() before calling this method', $code, $previous);
    }
}