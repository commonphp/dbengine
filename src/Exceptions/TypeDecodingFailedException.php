<?php

namespace CommonPHP\DatabaseEngine\Exceptions;

use CommonPHP\DatabaseEngine\Support\TypeConversionProvider;
use Throwable;

class TypeDecodingFailedException extends DatabaseEngineException
{
    public function __construct(mixed $data, string $expectedType, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('Could not decode data from '.TypeConversionProvider::getTypeOf($data).' to '.$expectedType.': '.($data === null ? '*NULL*' : ('`'.$data.'`')), $code, $previous);
    }
}