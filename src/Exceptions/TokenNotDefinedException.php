<?php

namespace CommonPHP\DatabaseEngine\Exceptions;

use Throwable;

class TokenNotDefinedException extends DatabaseEngineException
{
    public function __construct(string $name, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('The token \'{'.$name.'}\' was not found in the passed statement', $code, $previous);
    }
}