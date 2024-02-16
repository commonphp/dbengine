<?php

namespace CommonPHP\DatabaseEngine\TypeConverters;

use CommonPHP\DatabaseEngine\Contracts\TypeConverterContract;

class MixedTypeConverter implements TypeConverterContract
{

    #[\Override] function encode(mixed $data): mixed
    {
        return $data;
    }

    #[\Override] function decode(mixed $data): mixed
    {
        return $data;
    }
}