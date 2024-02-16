<?php

/**
 * Implements the QueryBuilder class, which provides a fluent interface for constructing SQL queries programmatically.
 * It allows for dynamic query construction, including the ability to append, replace, and build queries with parameters.
 * Additionally, it supports generating unique identifiers (UUIDs) for use in queries.
 *
 * This class adheres to the BuildableQueryContract, ensuring it implements a method to build the final Query object.
 * Exception handling is integrated to manage potential issues such as duplicate parameters or undefined tokens.
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
use CommonPHP\DatabaseEngine\Exceptions\DuplicateParameterNameException;
use CommonPHP\DatabaseEngine\Exceptions\EmptyParameterNameException;
use CommonPHP\DatabaseEngine\Exceptions\TokenNotDefinedException;
use CommonPHP\DatabaseEngine\Exceptions\UuidGenerationFailedException;
use Override;
use Random\RandomException;

final class QueryBuilder implements BuildableQueryContract
{
    /**
     * The SQL statement being built.
     *
     * @var string
     */
    private string $statement = '';

    /**
     * The parameters to be bound to the SQL statement.
     *
     * @var array
     */
    private array $parameters = [];

    /**
     * Indicates if parameters with the same name should be replaced.
     *
     * @var bool
     */
    public bool $allowParametersToBeReplaced = true;

    /**
     * Constructor is private to enforce usage of the static creation method.
     */
    private function __construct() { }

    /**
     * Creates a new instance of the QueryBuilder, optionally starting with a provided SQL statement and tokens.
     *
     * @param string|false $statement Initial SQL statement, if any.
     * @param string ...$tokens Tokens to replace within the initial statement.
     * @return QueryBuilder Returns a new instance of QueryBuilder.
     * @throws TokenNotDefinedException
     */
    public static function create(string|false $statement = false, string ... $tokens): QueryBuilder
    {
        $queryBuilder = new QueryBuilder();
        if ($statement !== false)
        {
            $queryBuilder->statement = $queryBuilder->iterateTokens($statement, $tokens);
        }
        return $queryBuilder;
    }

    /**
     * Appends a given statement to the current SQL statement, replacing any provided tokens.
     *
     * @param string $statement The statement to append.
     * @param string ...$tokens Tokens to replace in the statement.
     * @return self Returns the QueryBuilder instance for fluent interfacing.
     * @throws TokenNotDefinedException
     */
    public function append(string $statement, string ... $tokens): self
    {
        $this->statement .= $this->iterateTokens($statement, $tokens);
        return $this;
    }

    /**
     * Replaces the current SQL statement with a given statement, updating tokens as provided.
     *
     * @param string $statement The new statement to use.
     * @param string ...$tokens Tokens to replace in the new statement.
     * @return self Returns the QueryBuilder instance for fluent interfacing.
     * @throws TokenNotDefinedException
     */
    public function replace(string $statement, string ... $tokens): self
    {
        $this->statement = $this->iterateTokens($statement, $tokens);
        return $this;
    }

    /**
     * Constructs and returns a Query object from the current SQL statement and parameters.
     *
     * @return Query The constructed Query object.
     */
    #[Override] function build(): Query
    {
        return new Query($this->statement, $this->parameters);
    }

    /**
     * Generates a UUID and optionally associates it with a parameter name.
     *
     * @param ?string $name Optional parameter name to associate with the UUID.
     * @return string The parameter name.
     * @throws DuplicateParameterNameException
     * @throws EmptyParameterNameException
     * @throws UuidGenerationFailedException
     * @throws RandomException
     */
    public function makeUuid(?string $name = null): string
    {
        $length = 32;
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($length / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($length / 2));
        } else {
            throw new UuidGenerationFailedException();
        }
        $concatenated = substr(bin2hex($bytes), 0, $length);
        $uuid = substr($concatenated, 0, 8).'-'.
            substr($concatenated, 8, 4).'-'.
            substr($concatenated, 12, 4).'-'.
            substr($concatenated, 16, 4).'-'.
            substr($concatenated, 20, 12);
        if ($name === null)
        {
            $name = $this->MakeParameter($uuid);
        }
        else
        {
            $this->AddParameter($name, $uuid);
        }
        return $name;
    }

    /**
     * Generates a named parameter with an automatically determined name and associates it with a given value.
     *
     * @param mixed $value The value to associate with the generated parameter name.
     * @return string The generated parameter name.
     * @throws DuplicateParameterNameException
     * @throws EmptyParameterNameException
     */
    public function makeParameter(mixed $value): string
    {
        $name = $this->findFreeAutoParameter();
        $this->addParameter($name, $value);
        return $name;
    }

    /**
     * Adds a named parameter associated with a given value to the query, replacing it if allowed and already exists.
     *
     * @param string $name The name of the parameter.
     * @param mixed $value The value of the parameter.
     * @return self Returns the QueryBuilder instance for fluent interfacing.
     * @throws DuplicateParameterNameException
     * @throws EmptyParameterNameException
     */
    public function addParameter(string $name, mixed $value): self
    {
        $name = trim($name);
        if ($name == '')
        {
            throw new EmptyParameterNameException();
        }
        if (!$this->allowParametersToBeReplaced && isset($this->parameters[$name]))
        {
            throw new DuplicateParameterNameException($name);
        }
        $this->parameters[$name] = new QueryParameter($name, $value);
        return $this;
    }

    /**
     * Iterates over tokens in a statement and replaces them with their corresponding values.
     *
     * @param string $statement The SQL statement to process.
     * @param array $tokens The tokens to replace in the statement.
     * @return string The processed SQL statement.
     * @throws TokenNotDefinedException
     */
    private function iterateTokens(string $statement, array $tokens): string
    {
        foreach ($tokens as $index => $value)
        {
            if (!str_contains($statement, '{'.$index.'}'))
            {
                throw new TokenNotDefinedException($index);
            }
            $statement = str_replace('{'.$index.'}', $value, $statement);
        }
        return $statement;
    }

    /**
     * Finds a name for an auto-generated parameter that does not conflict with existing parameter names.
     *
     * @return string A unique parameter name.
     */
    private function findFreeAutoParameter(): string
    {
        $i = count($this->parameters) + 1;
        while (true)
        {
            $name = 'autoParameter'.$i;
            if (!isset($this->parameters[$name])) return $name;
            $i++;
        }
    }
}