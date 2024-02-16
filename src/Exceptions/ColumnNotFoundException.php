<?php

namespace CommonPHP\DatabaseEngine\Exceptions;

use Throwable;

class ColumnNotFoundException extends DatabaseEngineException
{
    public function __construct(string $name, array $names, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct('The column `'.$name.'` is not defined in the result ('.implode(', ', $names).')', $code, $previous);
    }
}