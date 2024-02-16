<?php

/**
 * Manages database connections and provides a unified interface for executing queries.
 * This class serves as a central point for managing multiple database connections,
 * facilitating the execution of queries and type conversion through registered type converters.
 *
 * @package CommonPHP
 * @subpackage DatabaseEngine
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 * @noinspection PhpUnused
 */

namespace CommonPHP\DatabaseEngine;

use CommonPHP\DatabaseEngine\Contracts\BuildableQueryContract;
use CommonPHP\DatabaseEngine\Contracts\ConnectorContract;
use CommonPHP\DatabaseEngine\Exceptions\ColumnNotFoundException;
use CommonPHP\DatabaseEngine\Exceptions\ConnectionAlreadyDefinedException;
use CommonPHP\DatabaseEngine\Exceptions\ConnectionNotRegisteredException;
use CommonPHP\DatabaseEngine\Exceptions\DatabaseEngineException;
use CommonPHP\DatabaseEngine\Exceptions\EmptyConnectionNameException;
use CommonPHP\DatabaseEngine\Exceptions\EmptyTypeNameException;
use CommonPHP\DatabaseEngine\Exceptions\ResultNotReadException;
use CommonPHP\DatabaseEngine\Support\TypeConversionProvider;
use CommonPHP\DatabaseEngine\TypeConverters\BoolTypeConverter;
use CommonPHP\DatabaseEngine\TypeConverters\DateTimeTypeConverter;
use CommonPHP\DatabaseEngine\TypeConverters\FloatTypeConverter;
use CommonPHP\DatabaseEngine\TypeConverters\IntTypeConverter;
use CommonPHP\DatabaseEngine\TypeConverters\MixedTypeConverter;
use CommonPHP\DatabaseEngine\TypeConverters\StringTypeConverter;
use DateTime;

final class ConnectionManager
{
    /**
     * @var ConnectorContract[] Holds the registered database connections.
     */
    private array $connections = [];

    /**
     * Provides type conversion services for database values.
     *
     * @var TypeConversionProvider
     */
    public readonly TypeConversionProvider $typeConversionProvider;

    /**
     * Initializes the ConnectionManager with an optional TypeConversionProvider.
     * Registers default type converters if not already supported by the provided TypeConversionProvider.
     *
     * @param TypeConversionProvider|null $typeConversionProvider The type conversion provider to use. A new instance is created if null is passed.
     * @throws EmptyTypeNameException
     */
    public function __construct(?TypeConversionProvider $typeConversionProvider = null)
    {
        if ($typeConversionProvider === null)
        {
            $typeConversionProvider = new TypeConversionProvider();
        }
        if (!$typeConversionProvider->supportsType('bool')) $typeConversionProvider->register('bool', new BoolTypeConverter());
        if (!$typeConversionProvider->supportsType(DateTime::class)) $typeConversionProvider->register(DateTime::class, new DateTimeTypeConverter());
        if (!$typeConversionProvider->supportsType('float')) $typeConversionProvider->register('float', new FloatTypeConverter());
        if (!$typeConversionProvider->supportsType('int')) $typeConversionProvider->register('int', new IntTypeConverter());
        if (!$typeConversionProvider->supportsType('mixed')) $typeConversionProvider->register('mixed', new MixedTypeConverter());
        if (!$typeConversionProvider->supportsType('string')) $typeConversionProvider->register('string', new StringTypeConverter());
        $this->typeConversionProvider = $typeConversionProvider;
    }

    /**
     * Retrieves a registered connector by name.
     *
     * @param string $connectionName The name of the connection to retrieve.
     * @return ConnectorContract The requested connector.
     * @throws ConnectionNotRegisteredException If the connection name is not registered.
     */
    public function with(string $connectionName): ConnectorContract
    {
        $name = trim(strtolower($connectionName));
        if (!isset($this->connections[$name]))
        {
            throw new ConnectionNotRegisteredException($connectionName);
        }
        return $this->connections[$name];
    }

    /**
     * Registers a new database connection under a specified name.
     *
     * @param string $connectionName The name to register the connection under.
     * @param ConnectorContract $connection The connector instance to register.
     * @throws EmptyConnectionNameException If the provided connection name is empty.
     * @throws ConnectionAlreadyDefinedException If a connection with the given name is already registered.
     */
    public function register(string $connectionName, ConnectorContract $connection): void
    {
        $name = trim(strtolower($connectionName));
        if ($name == '')
        {
            throw new EmptyConnectionNameException();
        }
        if (isset($this->connections[$name]))
        {
            throw new ConnectionAlreadyDefinedException($connectionName);
        }
        $this->connections[$name] = $connection;
    }

    /**
     * Retrieves the last insert ID from the specified connection.
     *
     * @param string $connectionName The name of the connection to retrieve the last insert ID from.
     * @return string|int The last insert ID as a string or integer, depending on the database.
     * @throws ConnectionNotRegisteredException
     */
    public function getLastInsertId(string $connectionName): string|int
    {
        return $this->with($connectionName)->getLastInsertId();
    }

    /**
     * Executes a non-query (e.g., INSERT, UPDATE, DELETE) using the specified connection.
     *
     * @param string $connectionName The name of the connection to use for execution.
     * @param Query|BuildableQueryContract $query The query to execute.
     * @return int The number of rows affected by the query.
     * @throws ConnectionNotRegisteredException
     */
    public function executeNonQuery(string $connectionName, Query|BuildableQueryContract $query): int
    {
        return $this->execute($connectionName, $query)->getRowCount();
    }

    /**
     * Executes a query that returns a single scalar value using the specified connection.
     *
     * @template T
     * @param string $connectionName The name of the connection to use for execution.
     * @param Query|BuildableQueryContract $query The query to execute.
     * @param class-string<T> $expectedType The expected return type of the query result.
     * @return T The scalar value returned by the query, converted to the specified type.
     * @throws ColumnNotFoundException
     * @throws ConnectionNotRegisteredException
     * @throws DatabaseEngineException
     * @throws ResultNotReadException
     */
    public function executeScalar(string $connectionName, Query|BuildableQueryContract $query, string $expectedType = 'mixed'): mixed
    {
        $scalar = null;
        $result = $this->execute($connectionName, $query);
        if ($result->read() && $result->getColumnCount() > 0)
        {
            $scalar = $result->getValue(0, $expectedType);
        }
        return $scalar;
    }

    /**
     * Executes a query using the specified connection and returns the result set.
     *
     * @param string $connectionName The name of the connection to use for execution.
     * @param Query|BuildableQueryContract $query The query to execute.
     * @return Result The result set of the executed query.
     * @throws ConnectionNotRegisteredException
     */
    public function execute(string $connectionName, Query|BuildableQueryContract $query): Result
    {
        return $this->with($connectionName)->execute($this->typeConversionProvider, $query);
    }
}