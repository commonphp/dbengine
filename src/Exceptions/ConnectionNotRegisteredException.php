<?php

namespace CommonPHP\DatabaseEngine\Exceptions;

use Throwable;

class ConnectionNotRegisteredException extends DatabaseEngineException
{
    public function __construct(string $name, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('There is no connection with the name `'.$name.'`', $code, $previous);
    }
}