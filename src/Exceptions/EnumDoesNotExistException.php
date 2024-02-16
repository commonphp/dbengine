<?php

namespace CommonPHP\DatabaseEngine\Exceptions;

use Throwable;

class EnumDoesNotExistException extends DatabaseEngineException
{
    public function __construct(string $name, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('There is no enum class found with the FQN `'.$name.'`', $code, $previous);
    }
}