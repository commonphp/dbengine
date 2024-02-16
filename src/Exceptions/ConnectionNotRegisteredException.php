<?php

/**
 * Exception thrown when a requested database connection name is not registered within the connection manager.
 * This highlights issues with connection configuration or naming mismatches in the application.
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

class ConnectionNotRegisteredException extends DatabaseEngineException
{
    /**
     * Initializes a new instance of ConnectionNotRegisteredException.
     * @param string $name The name of the unregistered connection.
     * @param ?Throwable $previous The previous throwable used for exception chaining.
     */
    public function __construct(string $name, ?Throwable $previous = null)
    {
        parent::__construct('There is no connection with the name `'.$name.'`', 1203, $previous);
    }
}
