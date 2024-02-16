<?php

namespace CommonPHP\DatabaseEngine\Exceptions;

use Throwable;

class DuplicateParameterNameException extends DatabaseEngineException
{
    public function __construct(string $name, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('The parameter name '.$name.' has already been defined', $code, $previous);
    }
}