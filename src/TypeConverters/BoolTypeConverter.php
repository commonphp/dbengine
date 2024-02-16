<?php

namespace CommonPHP\DatabaseEngine\TypeConverters;

use CommonPHP\DatabaseEngine\Contracts\TypeConverterContract;
use CommonPHP\DatabaseEngine\Exceptions\TypeDecodingFailedException;
use CommonPHP\DatabaseEngine\Exceptions\TypeEncodingFailedException;

class BoolTypeConverter implements TypeConverterContract
{
    #[\Override] function encode(mixed $data): mixed
    {
        if (!is_bool($data))
        {
            throw new TypeEncodingFailedException($data, 'bool');
        }
        return $data === true ? 'true' : 'false';
    }

    #[\Override] function decode(mixed $data): mixed
    {
        if ($data === null || strtolower($data) == 'false' || $data === 0 || $data === '0')
        {
            return false;
        }
        else if ((strtolower($data) == 'true' || $data === 1 || $data === '1'))
        {
            return true;
        }
        else
        {
            throw new TypeDecodingFailedException($data, 'bool');
        }
    }
}