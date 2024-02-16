<?php

/**
 * Exception thrown when a requested column is not found within a result set.
 * It provides details about the missing column and available columns, aiding in debugging and validation of result processing.
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

class ColumnNotFoundException extends DatabaseEngineException
{
    /**
     * Initializes a new instance of ColumnNotFoundException.
     * @param string $name The name of the missing column.
     * @param array $names An array of available column names for reference.
     * @param ?Throwable $previous The previous throwable used for exception chaining.
     */
    public function __construct(string $name, array $names, ?Throwable $previous = null)
    {
        parent::__construct('The column `'.$name.'` is not defined in the result ('.implode(', ', $names).')', 1201, $previous);
    }
}
