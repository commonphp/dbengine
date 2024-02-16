<?php

namespace CommonPHP\DatabaseEngine\Exceptions;

use Throwable;

class EmptyConnectionNameException extends DatabaseEngineException
{
    public function __construct(int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('A connection name cannot be empty', $code, $previous);
    }
}