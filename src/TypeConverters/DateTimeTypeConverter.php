<?php

/**
 * Handles the conversion of DateTime objects to and from database string representations.
 * It ensures that DateTime objects are properly formatted for database storage and accurately
 * reconstructed when retrieved, adhering to the TypeConverterContract interface.
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
use CommonPHP\DatabaseEngine\Exceptions\DatabaseEngineException;
use CommonPHP\DatabaseEngine\Exceptions\TypeDecodingFailedException;
use CommonPHP\DatabaseEngine\Exceptions\TypeEncodingFailedException;
use DateMalformedStringException;
use DateTime;
use Exception;
use Override;

class DateTimeTypeConverter implements TypeConverterContract
{
    /**
     * Converts a DateTime object into a database-friendly string format.
     * @param mixed $data The DateTime object to encode.
     * @return DateTime The string representation of the DateTime.
     * @throws TypeEncodingFailedException If the data is not a DateTime instance.
     * @noinspection PhpMixedReturnTypeCanBeReducedInspection
     */
    #[Override] function encode(mixed $data): mixed
    {
        if (!($data instanceof DateTime))
        {
            throw new TypeEncodingFailedException($data, DateTime::class);
        }
        return $data->format('Y-m-d H:i:s');
    }

    /**
     * Converts a database date/time string back into a DateTime object.
     * @param mixed $data The date/time string to decode.
     * @return DateTime The DateTime object.
     * @throws TypeDecodingFailedException If the data cannot be converted to DateTime.
     * @throws DatabaseEngineException
     * @noinspection PhpMixedReturnTypeCanBeReducedInspection
     */
    #[Override] function decode(mixed $data): mixed
    {
        if ($data === null) return null;
        try {
            return new DateTime((string)$data);
        } catch (DateMalformedStringException $e) {
            throw new TypeDecodingFailedException($data, DateTime::class, previous: $e);
        } catch (Exception $e) {
            throw new DatabaseEngineException(previous: $e);
        }
    }
}