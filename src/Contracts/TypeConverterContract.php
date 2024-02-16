<?php

/**
 * Defines the contract for type converters within the CommonPHP Database Engine.
 * Type converters are responsible for transforming PHP data types to their corresponding database types and vice versa.
 * This interface ensures a standardized approach to type conversion across different database implementations, enabling
 * the seamless integration of custom data types and enhancing the overall flexibility and robustness of database interactions.
 *
 * Implementing this contract requires providing methods for both encoding (PHP to database) and decoding (database to PHP)
 * operations, catering to the diverse needs of data persistence and retrieval within the application.
 *
 * @package CommonPHP
 * @subpackage DatabaseEngine
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 * @noinspection PhpUnused
 */

namespace CommonPHP\DatabaseEngine\Contracts;

interface TypeConverterContract
{
    /**
     * Encodes a PHP data type into a format suitable for database storage.
     * This method is designed to convert PHP types into their database-specific representations, ensuring that
     * data is correctly stored in a way that maintains its integrity and type information.
     *
     * @param mixed $data The PHP data to be encoded for the database.
     * @return mixed The data in a database-compatible format.
     */
    function encode(mixed $data): mixed;

    /**
     * Decodes a database data type back into its corresponding PHP type.
     * This process allows for the retrieval of data from the database and its conversion into PHP types, facilitating
     * the easy manipulation and use of database data within PHP applications.
     *
     * @param mixed $data The data retrieved from the database to be decoded into a PHP type.
     * @return mixed The PHP representation of the data.
     */
    function decode(mixed $data): mixed;
}