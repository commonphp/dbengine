<?php

namespace CommonPHP\DatabaseEngine\Exceptions;

use Throwable;

class UuidGenerationFailedException extends DatabaseEngineException
{
    public function __construct(int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('No cryptographically secure random function available', $code, $previous);
    }
}