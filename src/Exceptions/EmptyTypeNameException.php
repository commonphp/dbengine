<?php

/**
 * Exception thrown when a type name is provided as empty during type conversion operations.
 * This ensures that type names are specified, facilitating accurate and effective type conversion.
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

class EmptyTypeNameException extends DatabaseEngineException
{
    /**
     * Initializes a new instance of EmptyTypeNameException.
     * @param ?Throwable $previous The previous throwable used for exception chaining.
     */
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct('A type name cannot be empty', 1207, $previous);
    }
}
