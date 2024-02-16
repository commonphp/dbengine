<?php

/**
 * Exception thrown when decoding of a data type from the database to PHP fails.
 * This addresses issues where database data cannot be converted into the expected PHP type.
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

class TypeDecodingFailedException extends DatabaseEngineException
{
    /**
     * Initializes a new instance of TypeDecodingFailedException.
     * @param mixed $data The data that failed to be decoded.
     * @param string $expectedType The expected PHP type for the data.
     * @param ?Throwable $previous The previous throwable used for exception chaining.
     */
    public function __construct(mixed $data, string $expectedType, ?Throwable $previous = null)
    {
        parent::__construct('Could not decode data from '.TypeConversionProvider::getTypeOf($data).' to '.$expectedType.': '.($data === null ? '*NULL*' : ('`'.$data.'`')), 1212, $previous);
    }
}
