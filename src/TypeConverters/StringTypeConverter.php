<?php

namespace CommonPHP\DatabaseEngine\TypeConverters;

use CommonPHP\DatabaseEngine\Contracts\TypeConverterContract;

class StringTypeConverter implements TypeConverterContract
{

    #[\Override] function encode(mixed $data): mixed
    {
        return (string)$data;
    }

    #[\Override] function decode(mixed $data): mixed
    {
        return (string)$data;
    }
}