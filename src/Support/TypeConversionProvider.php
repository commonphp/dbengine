<?php

namespace CommonPHP\DatabaseEngine\Support;

use CommonPHP\DatabaseEngine\Contracts\TypeConverterContract;
use CommonPHP\DatabaseEngine\Exceptions\EmptyTypeNameException;
use CommonPHP\DatabaseEngine\Exceptions\TypeNotSupportedException;

class TypeConversionProvider
{
    public static function getTypeOf(mixed $data): string
    {
        $typeName = gettype($data);
        if ($typeName == 'object')
        {
            $typeName = get_class($data);
        }
        return $typeName;
    }

    /** @var TypeConverterContract[] */
    private $converters = [];

    public function register(string $typeName, TypeConverterContract $typeConverter): void
    {
        $name = $this->sanitizeTypeName($typeName);
        $this->converters[$name] = $typeConverter;
    }

    public function supportsType(string $typeName): bool
    {
        $name = $this->sanitizeTypeName($typeName);
        return isset($this->converters[$name]);
    }

    public function getTypeConverter(string $typeName): TypeConverterContract
    {
        $name = $this->sanitizeTypeName($typeName);
        if (!isset($this->converters[$name]))
        {
            throw new TypeNotSupportedException($typeName);
        }
        return $this->converters[$name];
    }

    public function encode(mixed $data): mixed
    {
        $typeName = self::getTypeOf($data);
        return $this->getTypeConverter($typeName)->encode($data);
    }

    public function decode(mixed $data): mixed
    {
        $typeName = self::getTypeOf($data);
        return $this->getTypeConverter($typeName)->decode($data);
    }

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