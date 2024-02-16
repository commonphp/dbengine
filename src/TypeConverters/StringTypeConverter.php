<?php

/**
 * Manages the conversion of string data between PHP and database formats.
 * This class implements the TypeConverterContract to encode and decode string
 * values, ensuring that strings are properly handled for database storage and retrieval.
 *
 * @package CommonPHP
 * @subpackage DatabaseEngine
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 * @noinspection PhpUnused
 */

namespace CommonPHP\DatabaseEngine\TypeConverters;

use CommonPHP\DatabaseEngine\Contracts\TypeConverterContract;
use Override;

class StringTypeConverter implements TypeConverterContract
{
    /**
     * Encodes a PHP string for database storage.
     * @param string $data The string to encode.
     * @return mixed The encoded string.
     * @noinspection PhpMixedReturnTypeCanBeReducedInspection
     */
    #[Override] function encode(mixed $data): mixed
    {
        return (string)$data;
    }

    /**
     * Decodes a database value back into a PHP string.
     * @param mixed $data The data to decode.
     * @return string The string value.
     * @noinspection PhpMixedReturnTypeCanBeReducedInspection
     */
    #[Override] function decode(mixed $data): mixed
    {
        return (string)$data;
    }
}