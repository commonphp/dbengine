<?php

/**
 * Exception thrown when an enumeration class does not exist or cannot be found.
 * This ensures that only valid enumeration types are utilized in database operations.
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

class EnumDoesNotExistException extends DatabaseEngineException
{
    /**
     * Initializes a new instance of EnumDoesNotExistException.
     * @param string $name The fully qualified name of the non-existent enum class.
     * @param ?Throwable $previous The previous throwable used for exception chaining.
     */
    public function __construct(string $name, ?Throwable $previous = null)
    {
        parent::__construct('There is no enum class found with the FQN `'.$name.'`', 1208, $previous);
    }
}
