<?php

/**
 * Provides conversion functionality for integer values between PHP and the database.
 * Implementing the TypeConverterContract, it ensures integers are correctly processed for
 * database operations, supporting both encoding and decoding actions.
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
use CommonPHP\DatabaseEngine\Exceptions\TypeDecodingFailedException;
use Override;

class IntTypeConverter implements TypeConverterContract
{
    /**
     * Encodes a PHP integer for database storage.
     * @param int $data The integer to encode.
     * @return mixed The encoded data.
     */

    #[Override] function encode(mixed $data): mixed
    {
        return $data;
    }

    /**
     * Decodes a database value back into a PHP integer.
     * @param mixed $data The data to decode.
     * @return int The integer value.
     * @throws TypeDecodingFailedException If the data cannot be accurately decoded into an integer.
     * @noinspection PhpMixedReturnTypeCanBeReducedInspection
     */
    #[Override] function decode(mixed $data): mixed
    {
        if ($data === null) return null;
        $intData = (int)$data;
        if ((string)$data !== (string)$intData)
        {
            throw new TypeDecodingFailedException($data, 'int');
        }
        return $intData;
    }
}