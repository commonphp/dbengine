<?php

/**
 * Exception thrown when an attempt is made to use a type converter that is not registered or supported.
 * This exception highlights the need for appropriate type converter registration to handle various data types.
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

class TypeNotSupportedException extends DatabaseEngineException
{
    /**
     * Initializes a new instance of TypeNotSupportedException.
     * @param string $name The name of the unsupported type.
     * @param ?Throwable $previous The previous throwable used for exception chaining.
     */
    public function __construct(string $name, ?Throwable $previous = null)
    {
        parent::__construct('There is no type converter registered for the type `'.$name.'`', 1214, $previous);
    }
}
