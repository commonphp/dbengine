<?php

namespace CommonPHP\DatabaseEngine\Contracts;

use BackedEnum;
use CommonPHP\DatabaseEngine\Exceptions\EnumDoesNotExistException;
use CommonPHP\DatabaseEngine\Exceptions\TypeDecodingFailedException;
use CommonPHP\DatabaseEngine\Exceptions\TypeEncodingFailedException;
use CommonPHP\DatabaseEngine\Support\TypeConversionProvider;
use UnitEnum;

class AbstractEnumTypeConverter implements TypeConverterContract
{
    /** @var string|UnitEnum|BackedEnum */
    private string|UnitEnum|BackedEnum $enumClass;

    public function __construct(string $enumClass)
    {
        if (!enum_exists($enumClass))
        {
            throw new EnumDoesNotExistException($enumClass);
        }
        $this->enumClass = $enumClass;
    }

    #[\Override] final function encode(mixed $data): mixed
    {
        $typeName = TypeConversionProvider::getTypeOf($data);
        if ($typeName !== $this->enumClass)
        {
            throw new TypeEncodingFailedException($data, $this->enumClass);
        }
        return $data->name;
    }

    #[\Override] final function decode(mixed $data): mixed
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
