<?php

namespace CommonPHP\DatabaseEngine\Exceptions;

use Throwable;

class TypeNotSupportedException extends DatabaseEngineException
{
    public function __construct(string $name, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('There is no type converter registered for the type `'.$name.'`', $code, $previous);
    }
}