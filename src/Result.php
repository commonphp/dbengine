<?php

namespace CommonPHP\DatabaseEngine;

use CommonPHP\DatabaseEngine\Exceptions\ColumnNotFoundException;
use CommonPHP\DatabaseEngine\Exceptions\DatabaseEngineException;
use CommonPHP\DatabaseEngine\Exceptions\OrdinalOutOfRangeException;
use CommonPHP\DatabaseEngine\Exceptions\ResultNotReadException;
use CommonPHP\DatabaseEngine\Support\TypeConversionProvider;
use Iterator;

final class Result
{
    private TypeConversionProvider $typeConversionProvider;
    private iterable $results;
    private int $rowCount;
    private array $columns = [];
    private array $ordinals = [];
    private false|array $currentRow = false;

    public function __construct(TypeConversionProvider $typeConversionProvider, int $rowCount, Iterator $results)
    {
        $this->typeConversionProvider = $typeConversionProvider;
        $this->rowCount = $rowCount;
        $this->results = $results;
        $this->results->rewind();
        $this->results->next();
        $row = $this->results->current();
        if (is_array($row))
        {
            $this->columns = array_keys($row);
            $this->ordinals = array_flip($this->columns);
        }
        $this->results->rewind();
    }

    public function read(): bool
    {
        $row = $this->results->current();
        if ($row === false) return false;
        $this->currentRow = array_values($row);
        $this->results->next();
        return true;
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }

    public function getColumnCount(): int
    {
        return count($this->columns);
    }

    public function getColumnNames(): array
    {
        return $this->columns;
    }

    public function getOrdinalOf(string $name): int
    {
        if (!$this->hasRead()) throw new ResultNotReadException();
        return !isset($this->ordinals[$name]) ? -1 : $this->ordinals[$name];
    }

    public function getNameOf(int $ordinal): string
    {
        if (!$this->hasRead()) throw new ResultNotReadException();
        return !isset($this->columns[$ordinal]) ? "" : $this->columns[$ordinal];
    }

    /**
     * @template T
     * @param string|int $nameOrOrdinal
     * @param class-string<T> $expectedType
     * @return T
     */
    public function getValue(string|int $nameOrOrdinal, string $expectedType = 'mixed'): mixed
    {
        if ($this->hasRead()) throw new ResultNotReadException();
        $name = '';
        $ordinal = -1;
        $this->getNameAndOrdinal($nameOrOrdinal, $name, $ordinal);
        try {
            $value = $this->getValueAt($ordinal);
        } catch (DatabaseEngineException $exception) {
            if (is_int($nameOrOrdinal)) throw $exception;
            throw new ColumnNotFoundException($name, $this->getColumnNames(), 0, $exception);
        }
        return $this->typeConversionProvider->decode($value);
    }

    private function getValueAt(int $ordinal): mixed
    {
        if ($ordinal < 0 || $ordinal > $this->getColumnCount())
        {
            throw new OrdinalOutOfRangeException($ordinal, 0, $this->getColumnCount());
        }
        return $this->currentRow[$ordinal];
    }

    private function getNameAndOrdinal(string|int $nameOrOrdinal, string &$name, int &$ordinal): void
    {
        $ordinal = is_int($nameOrOrdinal) ? $nameOrOrdinal : $this->getOrdinalOf($nameOrOrdinal);
        $name = is_int($nameOrOrdinal) ? $this->getNameOf($nameOrOrdinal) : $nameOrOrdinal;
    }

    private function hasRead(): bool
    {
        return $this->currentRow !== false;
    }
}