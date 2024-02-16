<?php

namespace CommonPHP\DatabaseEngine\Exceptions;

use Throwable;

class EmptyParameterNameException extends DatabaseEngineException
{
    public function __construct(int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('A parameter name cannot be empty', $code, $previous);
    }
}