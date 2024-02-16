<?php

/**
 * Provides a centralized mechanism for managing and utilizing type converters within the CommonPHP Database Engine.
 * This class facilitates the registration, querying, and usage of type converters that implement the TypeConverterContract,
 * enabling dynamic and flexible type conversion for database operations. It supports encoding and decoding of various
 * data types, ensuring that data is appropriately handled according to its PHP and database representations.
 *
 * @package CommonPHP
 * @subpackage DatabaseEngine
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 * @noinspection PhpUnused
 */

namespace CommonPHP\DatabaseEngine\Support;

use CommonPHP\DatabaseEngine\Contracts\TypeConverterContract;
use CommonPHP\DatabaseEngine\Exceptions\EmptyTypeNameException;
use CommonPHP\DatabaseEngine\Exceptions\TypeNotSupportedException;

class TypeConversionProvider
{
    /**
     * Determines the type of the given data, returning its PHP type or class name.
     *
     * @param mixed $data The data whose type is to be determined.
     * @return string The name of the data's type or its class name if an object.
     */
    public static function getTypeOf(mixed $data): string
    {
        $typeName = gettype($data);
        if ($typeName == 'object')
        {
            $typeName = get_class($data);
        }
        return $typeName;
    }

    /** @var TypeConverterContract[] Array of registered type converters, keyed by type name. */
    private array $converters = [];

    /**
     * Registers a type converter for a specific data type.
     *
     * @param string $typeName The name of the data type.
     * @param TypeConverterContract $typeConverter The type converter to register.
     * @throws EmptyTypeNameException
     */
    public function register(string $typeName, TypeConverterContract $typeConverter): void
    {
        $name = $this->sanitizeTypeName($typeName);
        $this->converters[$name] = $typeConverter;
    }


    /**
     * Checks if a type converter is registered for the specified type name.
     *
     * @param string $typeName The name of the data type.
     * @return bool True if a converter is registered for the type, false otherwise.
     * @throws EmptyTypeNameException
     */
    public function supportsType(string $typeName): bool
    {
        $name = $this->sanitizeTypeName($typeName);
        return isset($this->converters[$name]);
    }


    /**
     * Retrieves the type converter registered for the specified type name.
     *
     * @param string $typeName The name of the data type.
     * @return TypeConverterContract The registered type converter.
     * @throws TypeNotSupportedException
     * @throws EmptyTypeNameException
     */
    public function getTypeConverter(string $typeName): TypeConverterContract
    {
        $name = $this->sanitizeTypeName($typeName);
        if (!isset($this->converters[$name]))
        {
            throw new TypeNotSupportedException($typeName);
        }
        return $this->converters[$name];
    }


    /**
     * Encodes data to its database representation using the registered type converter for the specified type.
     *
     * @param mixed $data The data to encode.
     * @param string $typeName The name of the data type.
     * @return mixed The encoded data.
     * @throws TypeNotSupportedException
     * @throws EmptyTypeNameException
     */
    public function encode(mixed $data, string $typeName): mixed
    {
        return $this->getTypeConverter($typeName)->encode($data);
    }

    /**
     * Decodes data from its database representation to its PHP type using the registered type converter.
     *
     * @param mixed $data The data to decode.
     * @param string $typeName The name of the data type.
     * @return mixed The decoded data.
     * @throws TypeNotSupportedException
     * @throws EmptyTypeNameException
     */
    public function decode(mixed $data, string $typeName): mixed
    {
        return $this->getTypeConverter($typeName)->decode($data);
    }

    /**
     * Sanitizes the type name by trimming and converting to lowercase, ensuring consistency in type name handling.
     *
     * @param string $typeName The name of the data type.
     * @return string The sanitized type name.
     * @throws EmptyTypeNameException If the type name is empty after sanitization.
     */
    private function sanitizeTypeName(string $typeName): string
    {
        $name = trim(strtolower($typeName));
        if ($name == '')
        {
            throw new EmptyTypeNameException();
        }
        return $name;
    }

}