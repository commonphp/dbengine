# CommonPHP - Database Library

CommonPHP's Database Library is an advanced toolkit for database interaction and management in PHP applications. It offers a comprehensive set of features for connecting to databases, constructing queries, executing them, and handling results efficiently and securely.

## Features

- **Connection Management**: Simplifies the setup and management of database connections.
- **Query Builder**: Offers a fluent interface for constructing SQL queries to prevent syntax errors and SQL injection vulnerabilities.
- **Type Conversion**: Provides an extensible system for converting between PHP types and database types.
- **Exception Handling**: Includes detailed exceptions for precise error handling in database operations.

## Components

The library is structured into several key components, including the Connection Manager, Query Builder, and various type converters. It also defines interfaces and contracts for extendability, alongside a suite of exceptions for robust error management.

## Requirements

Requires PHP 8.1 or newer and is built to integrate seamlessly with other CommonPHP libraries.

## Installation

Use Composer to install:

```shell
# There is not yet a composer package for this library
```
### Basic Usage
Initialize the Connection Manager and use the Query Builder to create and execute database queries. Type converters can be used to handle complex data types, and exceptions are thrown for any errors encountered during database operations.

## Extending the Library
Custom type converters can be implemented by adhering to the provided interfaces, enhancing the library's flexibility and adaptability to different database systems and requirements.

## Documentation
For detailed examples and usage instructions, refer to the source code and PHPDoc comments within each component.

## Contributing
Contributions are welcome, following the contribution guidelines provided in the repository.

## Testing
The library includes unit tests using PHPUnit. Instructions for running tests are provided, encouraging contributions to maintain high test coverage.

## License
Licensed under the MIT License, promoting open and permissive usage in projects.