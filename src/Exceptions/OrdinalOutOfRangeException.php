<?php

namespace CommonPHP\DatabaseEngine\Exceptions;

use Throwable;

class OrdinalOutOfRangeException extends DatabaseEngineException
{
    public function __construct(int $ordinal, int $min, int $max, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('The ordinal '.$ordinal.' is out of range for the result (min: '.$min.', max:'.$max.')', $code, $previous);
    }
}