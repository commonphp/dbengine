<?php

namespace CommonPHP\DatabaseEngine\Contracts;

use CommonPHP\DatabaseEngine\Query;

interface BuildableQueryContract
{
    function build(): Query;
}