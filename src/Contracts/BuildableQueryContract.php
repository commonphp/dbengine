<?php

/**
 * Defines the contract for buildable query objects within the CommonPHP Database Engine.
 * Implementors of this interface are capable of constructing a Query object, which encapsulates
 * an SQL statement and its associated parameters. This interface facilitates a standardized approach
 * to dynamically building and executing database queries across various components of the database engine.
 *
 * @package CommonPHP
 * @subpackage DatabaseEngine
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 * @noinspection PhpUnused
 */

namespace CommonPHP\DatabaseEngine\Contracts;

use CommonPHP\DatabaseEngine\Query;

interface BuildableQueryContract
{
    /**
     * Constructs and returns a Query object.
     * This method allows implementing classes to define their own logic for building a query,
     * encapsulating the specifics of query construction within the implementing class.
     *
     * @return Query The constructed Query object.
     */
    function build(): Query;
}