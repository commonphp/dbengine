<?php /**  */

namespace CommonPHP\DatabaseEngine\TypeConverters;

/**
 * Provides a type converter for boolean values to and from database representations.
 * This class implements the TypeConverterContract, ensuring that boolean values are
 * correctly encoded for database storage and decoded back into PHP boolean types upon retrieval.
 *
 * @package CommonPHP
 * @subpackage DatabaseEngine
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 * @noinspection PhpUnused
 */

use CommonPHP\DatabaseEngine\Contracts\TypeConverterContract;
use CommonPHP\DatabaseEngine\Exceptions\TypeDecodingFailedException;
use CommonPHP\DatabaseEngine\Exceptions\TypeEncodingFailedException;
use Override;

class BoolTypeConverter implements TypeConverterContract
{
    /**
     * Encodes a PHP boolean into a string representation for database storage.
     * @param mixed $data The boolean to encode.
     * @return mixed A string 'true' or 'false' representing the boolean value.
     * @throws TypeEncodingFailedException If the data provided is not a boolean.
     * @noinspection PhpMixedReturnTypeCanBeReducedInspection
     */
    #[Override] function encode(mixed $data): mixed
    {
        if (!is_bool($data))
        {
            throw new TypeEncodingFailedException($data, 'bool');
        }
        return $data === true ? 'true' : 'false';
    }

    /**
     * Decodes a database value back into a PHP boolean.
     * @param mixed $data The data to decode.
     * @return bool The boolean value.
     * @throws TypeDecodingFailedException If the data cannot be decoded into a boolean.
     * @noinspection PhpMixedReturnTypeCanBeReducedInspection
     */
    #[Override] function decode(mixed $data): mixed
    {
        if ($data === null || strtolower($data) == 'false' || $data === 0 || $data === '0')
        {
            return false;
        }
        else if ((strtolower($data) == 'true' || $data === 1 || $data === '1'))
        {
            return true;
        }
        else
        {
            throw new TypeDecodingFailedException($data, 'bool');
        }
    }
}