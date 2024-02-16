<?php

namespace CommonPHP\DatabaseEngine\Contracts;

interface TypeConverterContract
{
    function encode(mixed $data): mixed;
    function decode(mixed $data): mixed;
}