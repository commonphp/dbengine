<?php

namespace CommonPHP\DatabaseEngine;

final readonly class Query
{
    public string $statement;
    public array $parameters;

    public function __construct(string $statement, array $parameters)
    {
        $this->statement = $statement;
        $this->parameters = $parameters;
    }
}