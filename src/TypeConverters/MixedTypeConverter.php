<?php

/**
 * A generic type converter for handling mixed data types between PHP and the database.
 * As per the TypeConverterContract, this converter does not alter the data type, allowing
 * for flexible data handling across a wide range of database operations.
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

class MixedTypeConverter implements TypeConverterContract
{
    /**
     * Passes through the data without conversion for encoding.
     * @param mixed $data The data to encode.
     * @return mixed The original data.
     */
    #[Override] function encode(mixed $data): mixed
    {
        return $data;
    }

    /**
     * Passes through the data without conversion for decoding.
     * @param mixed $data The data to decode.
     * @return mixed The original data.
     */
    #[Override] function decode(mixed $data): mixed
    {
        return $data;
    }
}