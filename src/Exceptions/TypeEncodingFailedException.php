<?php

/**
 * Exception thrown when encoding a PHP type to a database-compatible format fails.
 * This exception ensures that any issues encountered during the type encoding process are
 * clearly communicated, maintaining data integrity between PHP applications and the database.
 *
 * @package CommonPHP
 * @subpackage DatabaseEngine
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 * @noinspection PhpUnused
 */

namespace CommonPHP\DatabaseEngine\Exceptions;

use CommonPHP\DatabaseEngine\Support\TypeConversionProvider;
use Throwable;

class TypeEncodingFailedException extends DatabaseEngineException
{
    /**
     * Initializes a new instance of TypeEncodingFailedException.
     * @param mixed $data The data that could not be encoded.
     * @param string $targetType The target database type for encoding.
     * @param ?Throwable $previous The previous throwable used for exception chaining.
     */
    public function __construct(mixed $data, string $targetType, ?Throwable $previous = null)
    {
        parent::__construct('Could not encode data to '.$targetType.' from '.TypeConversionProvider::getTypeOf($data).': '.($data === null ? '*NULL*' : ('`'.$data.'`')), 1213, $previous);
    }
}
