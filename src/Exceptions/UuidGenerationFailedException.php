<?php

/**
 * Exception thrown when generating a UUID fails due to the lack of a cryptographically secure random function.
 * This ensures that UUID generation for database operations meets security requirements.
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

class UuidGenerationFailedException extends DatabaseEngineException
{
    /**
     * Initializes a new instance of UuidGenerationFailedException.
     * @param ?Throwable $previous The previous throwable used for exception chaining.
     */
    public function __construct(?Throwable $previous = null)
    {
        parent::__construct('No cryptographically secure random function available', 1215, $previous);
    }
}
