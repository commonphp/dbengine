<?php

namespace CommonPHP\DatabaseEngine\Exceptions;

use Throwable;

class EmptyTypeNameException extends DatabaseEngineException
{
    public function __construct(int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('A type name cannot be empty', $code, $previous);
    }
}