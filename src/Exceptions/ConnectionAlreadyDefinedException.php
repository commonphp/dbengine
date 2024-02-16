<?php

/**
 * Exception thrown when attempting to define a database connection that already exists.
 * This prevents overwriting existing connections, ensuring connection management integrity.
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

class ConnectionAlreadyDefinedException extends DatabaseEngineException
{
    /**
     * Initializes a new instance of ConnectionAlreadyDefinedException.
     * @param string $name The name of the connection attempted to be defined again.
     * @param ?Throwable $previous The previous throwable used for exception chaining.
     */
    public function __construct(string $name, ?Throwable $previous = null)
    {
        parent::__construct('Could not use the connection name `'.$name.'` because it already exists', 1202, $previous);
    }
}
