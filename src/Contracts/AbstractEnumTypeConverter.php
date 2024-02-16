<?php

/**
 * Implements conversion logic for PHP 8.1+ enumeration types to and from database representations.
 * This abstract class defines the functionality to serialize enum instances for storage in a database
 * and deserialize stored values back into enum instances. It ensures that only instances of the specified
 * enum class are handled, throwing exceptions if conversion fails due to type mismatches or unrecognized values.
 *
 * @package CommonPHP
 * @subpackage DatabaseEngine
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 * @noinspection PhpUnused
 * @noinspection PhpMixedReturnTypeCanBeReducedInspection
 */

namespace CommonPHP\DatabaseEngine\Contracts;

use BackedEnum;
use CommonPHP\DatabaseEngine\Exceptions\EnumDoesNotExistException;
use CommonPHP\DatabaseEngine\Exceptions\TypeDecodingFailedException;
use CommonPHP\DatabaseEngine\Exceptions\TypeEncodingFailedException;
use CommonPHP\DatabaseEngine\Support\TypeConversionProvider;
use Override;
use UnitEnum;

class AbstractEnumTypeConverter implements TypeConverterContract
{
    /**
     * The fully qualified class name of the enum this converter handles.
     * It must be a valid enumeration class, either a UnitEnum or BackedEnum.
     *
     * @var string|UnitEnum|BackedEnum
     */
    private string|UnitEnum|BackedEnum $enumClass;

    /**
     * Initializes a new instance of the AbstractEnumTypeConverter for a specific enum class.
     * Verifies the existence of the enum class, throwing an exception if the class does not exist.
     *
     * @param string $enumClass The fully qualified class name of the enum to be handled.
     * @throws EnumDoesNotExistException If the specified enum class does not exist.
     */
    public function __construct(string $enumClass)
    {
        if (!enum_exists($enumClass))
        {
            throw new EnumDoesNotExistException($enumClass);
        }
        $this->enumClass = $enumClass;
    }

    /**
     * Encodes an enum instance into a database-storable representation.
     * Currently, this method converts backed enums to their scalar values, ensuring the data is
     * compatible for database storage. It validates that the provided data matches the expected enum type.
     *
     * @param mixed $data The enum instance to encode.
     * @return mixed The encoded value suitable for database storage.
     * @throws TypeEncodingFailedException If encoding fails due to a type mismatch.
     */
    #[Override] final function encode(mixed $data): mixed
    {
        $typeName = TypeConversionProvider::getTypeOf($data);
        if ($typeName !== $this->enumClass)
        {
            throw new TypeEncodingFailedException($data, $this->enumClass);
        }
        return $data->name;
    }

    /**
     * Decodes a database-stored value back into an enum instance.
     * It iterates through the enum cases to find a match for the stored value, returning the corresponding enum case.
     *
     * @param mixed $data The database-stored value to decode.
     * @return mixed The corresponding enum instance, if a match is found.
     * @throws TypeDecodingFailedException If decoding fails because the stored value does not match any enum case.
     */
    #[Override] final function decode(mixed $data): mixed
    {
        foreach (($this->enumClass)::cases() as $case)
        {
            if ($case->name == $data)
            {
                return $case;
            }
        }
        throw new TypeDecodingFailedException($data, $this->enumClass);
    }
}
