<?php

/**
 * Represents the base exception class for all database engine-related errors within CommonPHP.
 * This class serves as a foundation for more specific database exceptions, providing a unified
 * structure for error handling and reporting across the database engine components.
 *
 * @package CommonPHP
 * @subpackage DatabaseEngine
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 * @noinspection PhpUnused
 */

namespace CommonPHP\DatabaseEngine\Exceptions;

use Exception;
use Throwable;

class DatabaseEngineException extends Exception
{
    /**
     * Initializes a new instance of the DatabaseEngineException.
     * @param string $message The error message.
     * @param int $code The exception code, default is 1200 for the base database engine exception.
     * @param ?Throwable $previous The previous throwable used for exception chaining.
     */
    public function __construct(string $message = "", int $code = 1200, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
