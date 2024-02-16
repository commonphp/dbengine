<?php /** @noinspection PhpUnused */

namespace CommonPHP\DatabaseEngine;

use CommonPHP\DatabaseEngine\Contracts\BuildableQueryContract;
use CommonPHP\DatabaseEngine\Exceptions\DuplicateParameterNameException;
use CommonPHP\DatabaseEngine\Exceptions\EmptyParameterNameException;
use CommonPHP\DatabaseEngine\Exceptions\TokenNotDefinedException;
use CommonPHP\DatabaseEngine\Exceptions\UuidGenerationFailedException;

final class QueryBuilder implements BuildableQueryContract
{
    public static function create(string|false $statement = false, string ... $tokens): QueryBuilder
    {
        $queryBuilder = new QueryBuilder();
        if ($statement !== false)
        {
            $queryBuilder->statement = $queryBuilder->iterateTokens($statement, $tokens);
        }
        return $queryBuilder;
    }

    private string $statement = '';
    private array $parameters = [];
    public bool $allowParametersToBeReplaced = true;

    private function __construct() { }

    public function append(string $statement, string ... $tokens): self
    {
        $this->statement .= $this->iterateTokens($statement, $tokens);
        return $this;
    }

    public function replace(string $statement, string ... $tokens): self
    {
        $this->statement = $this->iterateTokens($statement, $tokens);
        return $this;
    }

    #[\Override] function build(): Query
    {
        return new Query($this->statement, $this->parameters);
    }

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

    public function makeParameter(mixed $value): string
    {
        $name = $this->findFreeAutoParameter();
        $this->addParameter($name, $value);
        return $name;
    }

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

    private function findFreeAutoParameter(): string
    {
        $i = count($this->parameters) + 1;
        while (true)
        {
            $name = "autoParameter{$i}";
            if (!isset($this->parameters[$name])) return $name;
            $i++;
        }
    }
}