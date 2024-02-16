<?php

/**
 * Exception thrown when a specified token is not found within a query statement.
 * This ensures that all tokens needed for query execution are properly defined and available.
 *
 * @package CommonPHP
 * @subpackage DatabaseEngine
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 * @noinspection PhpUnused
 */

namespace CommonPHP\DatabaseEngine\Exceptions;

use Throwable;

class TokenNotDefinedException extends DatabaseEngineException
{
    /**
     * Initializes a new instance of TokenNotDefinedException.
     * @param string $name The name of the token that was not found.
     * @param ?Throwable $previous The previous throwable used for exception chaining.
     */
    public function __construct(string $name, ?Throwable $previous = null)
    {
        parent::__construct('The token \'{'.$name.'}\' was not found in the passed statement', 1211, $previous);
    }
}
