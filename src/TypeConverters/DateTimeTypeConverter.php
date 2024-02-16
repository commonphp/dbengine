<?php

namespace CommonPHP\DatabaseEngine\TypeConverters;

use CommonPHP\DatabaseEngine\Contracts\TypeConverterContract;
use CommonPHP\DatabaseEngine\Exceptions\DatabaseEngineException;
use CommonPHP\DatabaseEngine\Exceptions\TypeDecodingFailedException;
use CommonPHP\DatabaseEngine\Exceptions\TypeEncodingFailedException;
use DateMalformedStringException;
use DateTime;
use Exception;

class DateTimeTypeConverter implements TypeConverterContract
{

    #[\Override] function encode(mixed $data): mixed
    {
        if (!($data instanceof DateTime))
        {
            throw new TypeEncodingFailedException($data, DateTime::class);
        }
        return $data->format('Y-m-d H:i:s');
    }

    #[\Override] function decode(mixed $data): mixed
    {
        if ($data === null) return null;
        try {
            return new DateTime((string)$data);
        } catch (DateMalformedStringException $exception) {
            throw new TypeDecodingFailedException($data, DateTime::class);
        } catch (Exception $e) {
            throw new DatabaseEngineException("", 0, $e);
        }
    }
}