<?php

/**
 * Facilitates the conversion of floating-point numbers between PHP and database representations.
 * This class adheres to the TypeConverterContract, encoding and decoding float values to ensure
 * accurate and consistent handling of floating-point data within the database.
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

class FloatTypeConverter implements TypeConverterContract
{
    /**
     * Encodes a PHP float for database storage.
     * @param float $data The float value to encode.
     * @return mixed The encoded data.
     */
    #[Override] function encode(mixed $data): mixed
    {
        return $data;
    }

    /**
     * Decodes a database value back into a PHP float.
     * @param mixed $data The data to decode.
     * @return float The float value.
     * @throws TypeDecodingFailedException If the data cannot be accurately decoded into a float.
     * @noinspection PhpMixedReturnTypeCanBeReducedInspection
     */
    #[Override] function decode(mixed $data): mixed
    {
        if ($data === null) return null;
        $floatData = (float)$data;
        if ((string)$data !== (string)$floatData)
        {
            throw new TypeDecodingFailedException($data, 'float');
        }
        return $floatData;
    }
}