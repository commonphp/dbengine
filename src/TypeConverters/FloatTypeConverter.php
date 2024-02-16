<?php

namespace CommonPHP\DatabaseEngine\TypeConverters;

use CommonPHP\DatabaseEngine\Contracts\TypeConverterContract;
use CommonPHP\DatabaseEngine\Exceptions\TypeDecodingFailedException;

class FloatTypeConverter implements TypeConverterContract
{

    #[\Override] function encode(mixed $data): mixed
    {
        return $data;
    }

    #[\Override] function decode(mixed $data): mixed
    {
        if ($data === null) return null;
        $floatData = (float)$data;
        if ((string)$data !== (string)$floatData)
        {
            throw new TypeDecodingFailedException($data, 'float');
        }
        return $floatData;
    }
}