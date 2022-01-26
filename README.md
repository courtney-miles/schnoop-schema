# schnoop-schema
[![Tests](https://github.com/courtney-miles/schnoop-schema/actions/workflows/tests.yml/badge.svg)](https://github.com/courtney-miles/schnoop-schema/actions/workflows/tests.yml) [![Coverage Status](https://coveralls.io/repos/github/courtney-miles/schnoop-schema/badge.svg?branch=master)](https://coveralls.io/github/courtney-miles/schnoop-schema?branch=master)  [![Latest Stable Version](https://poser.pugx.org/milesasylum/schnoop-schema/v/stable)](https://packagist.org/packages/milesasylum/schnoop-schema) [![Total Downloads](https://poser.pugx.org/milesasylum/schnoop-schema/downloads)](https://packagist.org/packages/milesasylum/schnoop-schema) [![License](https://poser.pugx.org/milesasylum/schnoop-schema/license)](https://packagist.org/packages/milesasylum/schnoop-schema)

Schnoop Schema is a collection of PHP classes for describing a MySQL database schema and providing the DDL statements for that schema.

Its intended purpose is to be a code-generator, by making it easy to use PHP to script to creation of DDL statements for tables, routines, etc.

This package does not interact with a database server, but for an implementation that does, checkout [milesasylum/Schnoop](https://packagist.org/packages/milesasylum/schnoop).

With Schnoop-Scheme you can describe the following database definitions:

* Databases
* Tables
  * Columns
  * Indexes
  * Foreign keys
  * Triggers
* Functions
* Procedures

> **Disclaimer:** It is not advisable to use this package in production environment -- it's is suitable only for development environments to assist with code generation.

## Examples

### Create database

```php
<?php

use MilesAsylum\SchnoopSchema\MySQL\Database\Database;

$database = new Database('schnoop_db');
$database->setDefaultCollation('utf8mb4_general_ci');
$database->setDelimiter('$$');
$database->setDropPolicy(Database::DDL_DROP_POLICY_DROP_IF_EXISTS);
echo $database->getCreateStatement();
/*
DROP DATABASE IF EXISTS `schnoop_db`$$
CREATE DATABASE `schnoop_db` DEFAULT COLLATION 'utf8mb4_general_ci'$$
*/
```

### Create table

```php
<?php

use MilesAsylum\SchnoopSchema\MySQL\Table\Table;

// Create Table.
$table = new Table('schnoop_tbl');
$table->setEngine(Table::ENGINE_INNODB);
$table->setDefaultCollation('utf8mb4_general_ci');

```
#### Add columns to the table

```php
<?php

// ...
use MilesAsylum\SchnoopSchema\MySQL\Column\Column;
use MilesAsylum\SchnoopSchema\MySQL\DataType\IntType;
use MilesAsylum\SchnoopSchema\MySQL\DataType\VarCharType;
use MilesAsylum\SchnoopSchema\MySQL\DataType\TimestampType;

// ...

// Add an ID column.
$idType = new IntType();
$idType->setSigned(false);
$idColumn = new Column('id', $idType);
$idColumn->setAutoIncrement(true);
$idColumn->setNullable(false);
$table->addColumn($idColumn);

// Add a name column.
$nameType = new VarCharType(50);
$nameType->setCollation('ascii_general_ci');
$nameColumn = new Column('name', $nameType);
$table->addColumn($nameColumn);

// Add an updated-at column.
$updatedAtType = new TimestampType();
$updatedAtType->setPrecision(2);
$updatedAtColumn = new Column('updated_at', $updatedAtType);
$updatedAtColumn->setOnUpdateCurrentTimestamp(true);
$updatedAtColumn->setNullable(false);
$table->addColumn($updatedAtColumn);
```
#### Add indexes to the table

```php
<?php

// ...
use MilesAsylum\SchnoopSchema\MySQL\Constraint\PrimaryKey;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\Index;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexedColumn;

// ...

// Add a primary key
$pkIndex = new PrimaryKey();
$pkIndex->addIndexedColumn(
    new IndexedColumn($idColumn->getName())
);
$table->addIndex($pkIndex);

// Add an index on the first 8 characters of the name column.
$nameIndexedColumn = new IndexedColumn($nameColumn->getName());
$nameIndexedColumn->setLength(8);
$nameIndex = new Index('name_idx');
$nameIndex->addIndexedColumn($nameIndexedColumn);
$table->addIndex($nameIndex);
```

## TODO

* Add support for Views.