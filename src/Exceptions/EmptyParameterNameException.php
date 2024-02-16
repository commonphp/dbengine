<?php

/**
 * Exception thrown when a parameter name is provided as empty.
 * This highlights issues with query construction, where parameter names must be clearly defined.
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

class EmptyParameterNameException extends DatabaseEngineException
{
    /**
     * Initializes a new instance of EmptyParameterNameException.
     * @param ?Throwable $previous The previous throwable used for exception chaining.
     */
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct('A parameter name cannot be empty', 1206, $previous);
    }
}
