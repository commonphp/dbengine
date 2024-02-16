<?php

namespace CommonPHP\DatabaseEngine\TypeConverters;

use CommonPHP\DatabaseEngine\Contracts\TypeConverterContract;
use CommonPHP\DatabaseEngine\Exceptions\TypeDecodingFailedException;

class IntTypeConverter implements TypeConverterContract
{

    #[\Override] function encode(mixed $data): mixed
    {
        return $data;
    }

    #[\Override] function decode(mixed $data): mixed
    {
        if ($data === null) return null;
        $intData = (int)$data;
        if ((string)$data !== (string)$intData)
        {
            throw new TypeDecodingFailedException($data, 'int');
        }
        return $intData;
    }
}