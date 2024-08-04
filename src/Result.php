<?php
/**
 * Manages the results returned from executing a database query, providing methods to navigate and access data.
 * It encapsulates result set handling, including row counting, column metadata retrieval, and type-safe value access.
 * The class leverages a TypeConversionProvider to facilitate the conversion of database types to PHP types, enhancing
 * the robustness and flexibility of data handling within the CommonPHP Database Engine.
 *
 * Exception handling is integrated for scenarios like accessing undefined columns or reading data beyond the result set.
 *
 * @package CommonPHP
 * @subpackage DatabaseEngine
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 * @noinspection PhpUnused
 */

namespace CommonPHP\DatabaseEngine;

use CommonPHP\DatabaseEngine\Exceptions\ColumnNotFoundException;
use CommonPHP\DatabaseEngine\Exceptions\DatabaseEngineException;
use CommonPHP\DatabaseEngine\Exceptions\EmptyTypeNameException;
use CommonPHP\DatabaseEngine\Exceptions\OrdinalOutOfRangeException;
use CommonPHP\DatabaseEngine\Exceptions\ResultNotReadException;
use CommonPHP\DatabaseEngine\Exceptions\TypeNotSupportedException;
use CommonPHP\DatabaseEngine\Support\TypeConversionProvider;
use Iterator;

final class Result
{
    /** @var TypeConversionProvider Provides type conversion services for result values. */
    private TypeConversionProvider $typeConversionProvider;

    /** @var iterable The iterable result set from the database query. */
    private iterable $results;

    /** @var int The total number of rows in the result set. */
    private int $rowCount;

    /** @var array A list of column names in the result set. */
    private array $columns = [];

    /** @var array Maps column names to their ordinal positions in the result set. */
    private array $ordinals = [];

    /** @var false|array The current row's data or false if no current row. */
    private false|array $currentRow = false;

    /**
     * Initializes a new instance of the Result class with the provided type conversion provider, row count, and result iterator.
     *
     * @param TypeConversionProvider $typeConversionProvider The provider for type conversion.
     * @param int $rowCount The total number of rows, counted or affected, in the result set.
     * @param Iterator $results The iterator for the result set.
     */
    public function __construct(TypeConversionProvider $typeConversionProvider, int $rowCount, Iterator $results)
    {
        $this->typeConversionProvider = $typeConversionProvider;
        $this->rowCount = $rowCount;
        $this->results = $results;
        $this->results->rewind();
        $row = $this->results->current();
        if (is_array($row))
        {
            $this->columns = array_keys($row);
            $this->ordinals = array_flip($this->columns);
        }
        $this->results->rewind();
    }

    /**
     * Advances the result set to the next row and updates the current row data.
     *
     * @return bool True if a new row is read; false if no more rows are available.
     */
    public function read(): bool
    {
        $row = $this->results->current();
        if ($row === false) return false;
        $this->currentRow = array_values($row);
        $this->results->next();
        return true;
    }

    /** @return int Returns the total number of rows in the result set. */
    public function getRowCount(): int
    {
        return $this->rowCount;
    }

    /** @return int Returns the number of columns in the current row of the result set. */
    public function getColumnCount(): int
    {
        return count($this->columns);
    }

    /** @return array Returns an array of column names in the result set. */
    public function getColumnNames(): array
    {
        return $this->columns;
    }

    /**
     * Retrieves the ordinal position of a column given its name.
     *
     * @param string $name The name of the column.
     * @return int The ordinal position of the column or -1 if not found.
     * @throws ResultNotReadException
     */
    public function getOrdinalOf(string $name): int
    {
        if (!$this->hasRead()) throw new ResultNotReadException();
        return !isset($this->ordinals[$name]) ? -1 : $this->ordinals[$name];
    }

    /**
     * Retrieves the name of a column given its ordinal position.
     *
     * @param int $ordinal The ordinal position of the column.
     * @return string The name of the column or an empty string if not found.
     * @throws ResultNotReadException
     */
    public function getNameOf(int $ordinal): string
    {
        if (!$this->hasRead()) throw new ResultNotReadException();
        return !isset($this->columns[$ordinal]) ? "" : $this->columns[$ordinal];
    }

    /**
     * Retrieves the value of a specified column in the current row, with type conversion as necessary.
     *
     * @template T
     * @param string|int $nameOrOrdinal The name or ordinal of the column.
     * @param class-string<T> $expectedType The expected PHP type of the column value.
     * @return T The value of the column, converted to the specified type.
     * @throws ColumnNotFoundException
     * @throws EmptyTypeNameException
     * @throws TypeNotSupportedException
     * @throws OrdinalOutOfRangeException
     * @throws ResultNotReadException
     */
    public function getValue(string|int $nameOrOrdinal, string $expectedType = 'mixed'): mixed
    {
        if (!$this->hasRead()) throw new ResultNotReadException();
        $name = '';
        $ordinal = -1;
        $this->getNameAndOrdinal($nameOrOrdinal, $name, $ordinal);
        try {
            $value = $this->getValueAt($ordinal);
        } catch (DatabaseEngineException $exception) {
            if (is_int($nameOrOrdinal)) throw $exception;
            throw new ColumnNotFoundException($name, $this->getColumnNames(), $exception);
        }
        return $this->typeConversionProvider->decode($value, $expectedType);
    }

    /**
     * Retrieves the value at a specified ordinal position in the current row.
     *
     * @param int $ordinal The ordinal position of the value.
     * @return mixed The value at the specified position.
     * @throws OrdinalOutOfRangeException
     */
    private function getValueAt(int $ordinal): mixed
    {
        if ($ordinal < 0 || $ordinal > $this->getColumnCount())
        {
            throw new OrdinalOutOfRangeException($ordinal, 0, $this->getColumnCount());
        }
        return $this->currentRow[$ordinal];
    }

    /**
     * Determines the name and ordinal of a column based on a given identifier, which may be a name or an ordinal.
     *
     * @param string|int $nameOrOrdinal The column identifier.
     * @param string &$name The variable to store the column name.
     * @param int &$ordinal The variable to store the column ordinal.
     * @throws ResultNotReadException
     */
    private function getNameAndOrdinal(string|int $nameOrOrdinal, string &$name, int &$ordinal): void
    {
        $ordinal = is_int($nameOrOrdinal) ? $nameOrOrdinal : $this->getOrdinalOf($nameOrOrdinal);
        $name = is_int($nameOrOrdinal) ? $this->getNameOf($nameOrOrdinal) : $nameOrOrdinal;
    }

    /** @return bool Returns true if the current row has been read; otherwise, false. */
    private function hasRead(): bool
    {
        return $this->currentRow !== false;
    }
}
