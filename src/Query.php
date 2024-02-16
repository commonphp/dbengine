<?php

/**
 * Provides a representation of a database query, encapsulating both the SQL statement and its associated parameters.
 *
 * This class is designed to be immutable, with all properties being read-only to ensure the integrity of the query
 * information once instantiated. It is part of the CommonPHP Database Engine, offering a structured approach to
 * managing database queries.
 *
 * @package CommonPHP
 * @subpackage DatabaseEngine
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 * @noinspection PhpUnused
 */

namespace CommonPHP\DatabaseEngine;

final readonly class Query
{
    /**
     * The SQL statement for the query.
     *
     * @var string
     */
    public string $statement;

    /**
     * The parameters to be bound to the SQL statement.
     *
     * @var array
     */
    public array $parameters;

    /**
     * Constructs a new Query instance with the given SQL statement and parameters.
     *
     * @param string $statement The SQL statement of the query.
     * @param array $parameters The parameters to be bound to the SQL statement.
     */
    public function __construct(string $statement, array $parameters)
    {
        $this->statement = $statement;
        $this->parameters = $parameters;
    }
}