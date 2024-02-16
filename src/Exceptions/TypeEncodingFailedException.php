<?php

namespace CommonPHP\DatabaseEngine\Exceptions;

use CommonPHP\DatabaseEngine\Support\TypeConversionProvider;
use Throwable;

class TypeEncodingFailedException extends DatabaseEngineException
{
    public function __construct(mixed $data, string $targetType, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('Could not encode data to '.$targetType.' from '.TypeConversionProvider::getTypeOf($data).': '.($data === null ? '*NULL*' : ('`'.$data.'`')), $code, $previous);
    }
}