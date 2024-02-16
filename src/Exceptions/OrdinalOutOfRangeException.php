<?php

/**
 * Exception thrown when an ordinal value is outside the allowable range.
 * This typically occurs during data retrieval operations when specifying a column or parameter position.
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

class OrdinalOutOfRangeException extends DatabaseEngineException
{
    /**
     * Initializes a new instance of OrdinalOutOfRangeException.
     * @param int $ordinal The ordinal value that was out of range.
     * @param int $min The minimum allowed ordinal value.
     * @param int $max The maximum allowed ordinal value.
     * @param ?Throwable $previous The previous throwable used for exception chaining.
     */
    public function __construct(int $ordinal, int $min, int $max, ?Throwable $previous = null)
    {
        parent::__construct('The ordinal '.$ordinal.' is out of range for the result (min: '.$min.', max:'.$max.')', 1209, $previous);
    }
}
