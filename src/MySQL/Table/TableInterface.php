<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\Table;

use MilesAsylum\SchnoopSchema\MySQL\Column\ColumnInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\ConstraintInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\ForeignKeyInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\PrimaryKey;
use MilesAsylum\SchnoopSchema\MySQL\CreateStatementInterface;
use MilesAsylum\SchnoopSchema\MySQL\DroppableInterface;
use MilesAsylum\SchnoopSchema\MySQL\HasDelimiterInterface;
use MilesAsylum\SchnoopSchema\MySQL\MySQLInterface;

interface TableInterface extends MySQLInterface, HasDelimiterInterface, DroppableInterface, CreateStatementInterface
{
    /**
     * MySQL keyword for the InnoDB table engine.
     */
    public const ENGINE_INNODB = 'INNODB';

    /**
     * MySQL keyword for the Memory table engine.
     */
    public const ENGINE_MEMORY = 'MEMORY';

    /**
     * MySQL keyword for the table default row format.
     */
    public const ROW_FORMAT_DEFAULT = 'DEFAULT';

    /**
     * MySQL keyword for the table dynamic row format.
     */
    public const ROW_FORMAT_DYNAMIC = 'DYNAMIC';

    /**
     * MySQL keyword for the table fixed row format.
     */
    public const ROW_FORMAT_FIXED = 'FIXED';

    /**
     * MySQL keyword for the table compressed row format.
     */
    public const ROW_FORMAT_COMPRESSED = 'COMPRESSED';

    /**
     * MySQL keyword for the table redundant row format.
     */
    public const ROW_FORMAT_REDUNDANT = 'REDUNDANT';

    /**
     * MySQL keyword for the table compact row format.
     */
    public const ROW_FORMAT_COMPACT = 'COMPACT';

    /**
     * Get the table name.
     *
     * @return string table name
     */
    public function getName();

    /**
     * Set the table name.
     *
     * @param string $name table name
     */
    public function setName($name);

    /**
     * Get the database name.
     *
     * @return string database name
     */
    public function getDatabaseName();

    /**
     * Indicates if a database name is set for the table.
     *
     * @return bool returns true if table has a database name set
     */
    public function hasDatabaseName();

    /**
     * Set the database name for the table.
     *
     * @param string $databaseName database name
     */
    public function setDatabaseName($databaseName);

    /**
     * Get the names of all columns in the table.
     *
     * @return array column names
     */
    public function getColumnList();

    /**
     * Get all the columns for the table.
     *
     * @return ColumnInterface[] Columns
     */
    public function getColumns();

    /**
     * Identify if a column with the supplied name exists in the table.
     *
     * @param string $columnName column name
     *
     * @return bool returns true if the a column exists with the supplied name
     */
    public function hasColumn($columnName);

    /**
     * Get a column by its name.
     *
     * @param string $columnName Column name
     *
     * @return ColumnInterface returns the column for the supplied name, or
     *                         NULL if the column does not exist
     */
    public function getColumn($columnName);

    /**
     * Set the columns for the table.
     *
     * @param ColumnInterface[] $columns array of columns for the table
     */
    public function setColumns(array $columns);

    /**
     * Add a column to the table.
     *
     * @param ColumnInterface $column column to add
     */
    public function addColumn(ColumnInterface $column);

    /**
     * Get the names of all indexes on the table.
     *
     * @return array index names
     */
    public function getIndexList();

    /**
     * Get the indexes on the table.
     *
     * @return IndexInterface[] array of indexes
     */
    public function getIndexes();

    /**
     * Identify if the table has an index with the given name.
     *
     * @param string $indexName the name of the index to look for
     *
     * @return bool mixed True if the named index is found
     */
    public function hasIndex($indexName);

    /**
     * Gets an index by it's name.
     *
     * @param string $indexName the index name
     *
     * @return IndexInterface the index
     */
    public function getIndex($indexName);

    /**
     * Set all indexes on the table.
     *
     * @param ConstraintInterface[] $indexes array of indexes to set
     */
    public function setIndexes(array $indexes);

    /**
     * Add an index on the table.
     *
     * @param ConstraintInterface $index the index to add
     */
    public function addIndex(ConstraintInterface $index);

    /**
     * Indicates if the table has a primary key.
     *
     * @return bool true if a primary key exists
     */
    public function hasPrimaryKey();

    /**
     * Gets the primary key for the table.
     *
     * @return PrimaryKey The primary key.  Null if a primary key does not exists.
     */
    public function getPrimaryKey();

    /**
     * Returns the names of the foreign keys on the table.
     *
     * @return array foreign key names
     */
    public function getForeignKeyList();

    /**
     * Get all the foreign keys on the table.
     *
     * @return ForeignKeyInterface[] array of foreign keys
     */
    public function getForeignKeys();

    /**
     * Get a foreign key by its name.
     *
     * @param string $foreignKeyName the name of the foreign key to get
     *
     * @return ForeignKeyInterface
     */
    public function getForeignKey($foreignKeyName);

    /**
     * Identify if the table has a foreign key with the supplied name.
     *
     * @param string $foreignKeyName the name of the foreign key to check for
     *
     * @return bool true if the named foreign key exists
     */
    public function hasForeignKey($foreignKeyName);

    /**
     * Set the foreign keys on the table.
     *
     * @param ForeignKeyInterface[] $foreignKeys foreign keys to set
     */
    public function setForeignKeys(array $foreignKeys);

    /**
     * Add a foreign key to the table.
     *
     * @param ForeignKeyInterface $foreignKey foreign key to add
     */
    public function addForeignKey(ForeignKeyInterface $foreignKey);

    /**
     * Get the table engine.
     *
     * @return string the table engine, or NULL if it has not been set
     */
    public function getEngine();

    /**
     * Indicates if the table has an engine specified.
     *
     * @return bool true if an engine is specified
     */
    public function hasEngine();

    /**
     * Set the table engine.
     *
     * @param string $engine the table engine
     */
    public function setEngine($engine);

    /**
     * Get the default collation for the table.
     *
     * @return string the default collation, or null if a collation is not set
     */
    public function getDefaultCollation();

    /**
     * Indicates if the default collation is set for the table.
     *
     * @return bool true if the collation is set
     */
    public function hasDefaultCollation();

    /**
     * Set the default collation for the table.
     *
     * @param string $defaultCollation the default collation
     */
    public function setDefaultCollation($defaultCollation);

    /**
     * Get the row format for the table.
     *
     * @return string the row format, null if the row format is not set
     */
    public function getRowFormat();

    /**
     * Indicates if the table has the row format specified.
     *
     * @return bool true if the row format is set
     */
    public function hasRowFormat();

    /**
     * Set the row format on the table.
     *
     * @param string $rowFormat the row format
     */
    public function setRowFormat($rowFormat);

    /**
     * Get the comment for the table.
     *
     * @return string the comment, or null if a comment is not set
     */
    public function getComment();

    /**
     * Indicates if a comment is set for the table.
     *
     * @return bool true if a comment is set
     */
    public function hasComment();

    /**
     * Set a comment for the table.
     *
     * @param string $comment the comment
     */
    public function setComment($comment);

    /**
     * The table DDL create statement.
     *
     * @uses TableInterface::getCreateStatement()
     *
     * @return string the DDL create statement
     */
    public function __toString();
}
