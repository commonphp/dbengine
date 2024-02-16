<?php
/**
 * Represents a single parameter in a database query, holding both the parameter's name and its value.
 * This class is designed to facilitate the management and usage of parameters within SQL queries, ensuring
 * that values are correctly associated with their respective placeholders in a query statement.
 *
 * The class is marked as final and read-only to ensure immutability of parameter instances once they are created,
 * which helps in maintaining the integrity of query construction and execution within the CommonPHP Database Engine.
 *
 * @package CommonPHP
 * @subpackage DatabaseEngine
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 * @noinspection PhpUnused
 */

namespace CommonPHP\DatabaseEngine;

final readonly class QueryParameter
{
    /**
     * The name of the query parameter.
     *
     * @var string
     */
    public string $name;

    /**
     * The value of the query parameter.
     *
     * @var mixed
     */
    public mixed $value;

    /**
     * Constructs a new QueryParameter instance with a specified name and value.
     *
     * @param string $name The name of the query parameter.
     * @param mixed $value The value to be bound to the query parameter.
     */
    public function __construct(string $name, mixed $value)
    {
        $this->name = $name;
        $this->value = $value;
    }
}