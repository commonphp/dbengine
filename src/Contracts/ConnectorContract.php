<?php

namespace CommonPHP\DatabaseEngine\Contracts;

use CommonPHP\DatabaseEngine\Query;
use CommonPHP\DatabaseEngine\Result;
use CommonPHP\DatabaseEngine\Support\TypeConversionProvider;

interface ConnectorContract
{
    function getLastInsertId(): string|int;
    function execute(TypeConversionProvider $typeConversionProvider, Query|BuildableQueryContract $query): Result;
}