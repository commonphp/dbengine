<?php

/**
 * Exception thrown when a duplicate parameter name is defined in a query, violating the uniqueness constraint.
 * This ensures parameter names in queries are distinct, preventing unexpected behavior during query execution.
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

class DuplicateParameterNameException extends DatabaseEngineException
{
    /**
     * Initializes a new instance of DuplicateParameterNameException.
     * @param string $name The name of the parameter that was duplicated.
     * @param ?Throwable $previous The previous throwable used for exception chaining.
     */
    public function __construct(string $name, ?Throwable $previous = null)
    {
        parent::__construct('The parameter name `'.$name.'` has already been defined', 1204, $previous);
    }
}
