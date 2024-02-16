<?php

namespace CommonPHP\DatabaseEngine\Exceptions;

use Throwable;

class ConnectionAlreadyDefinedException extends DatabaseEngineException
{
    public function __construct(string $name, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('Could not use the connection name `'.$name.'` because it already exists', $code, $previous);
    }
}