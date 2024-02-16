<?php

/**
 * Exception thrown when an attempt is made to access result data before the result set has been read.
 * This enforces the correct sequence of operations when working with database results, ensuring data integrity.
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

class ResultNotReadException extends DatabaseEngineException
{
    /**
     * Initializes a new instance of ResultNotReadException.
     * @param ?Throwable $previous The previous throwable used for exception chaining.
     */
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct('You must call Result::Read() before calling this method', 1210, $previous);
    }
}
