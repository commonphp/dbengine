<?php

namespace CommonPHP\DatabaseEngine;

final readonly class QueryParameter
{
    public string $name;
    public mixed $value;

    public function __construct(string $name, mixed $value)
    {
        $this->name = $name;
        $this->value = $value;
    }
}