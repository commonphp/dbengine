<?php

/**
 * Exception thrown when a connection name provided is empty.
 * This enforces the requirement for meaningful, non-empty identifiers for database connections.
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

class EmptyConnectionNameException extends DatabaseEngineException
{
    /**
     * Initializes a new instance of EmptyConnectionNameException.
     * @param ?Throwable $previous The previous throwable used for exception chaining.
     */
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct('A connection name cannot be empty', 1205, $previous);
    }
}
