<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Table;

use MilesAsylum\SchnoopSchema\MySQL\Column\ColumnInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\ConstraintInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\ForeignKeyInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\PrimaryKey;
use MilesAsylum\SchnoopSchema\MySQL\MySQLInterface;

interface TableInterface extends MySQLInterface
{
    /**
     * MySQL keyword for the InnoDB table engine.
     */
    const ENGINE_INNODB = 'INNODB';

    /**
     * MySQL keyword for the Memory table engine.
     */
    const ENGINE_MEMORY = 'MEMORY';

    /**
     * MySQL keyword for the table default row format.
     */
    const ROW_FORMAT_DEFAULT = 'DEFAULT';

    /**
     * MySQL keyword for the table dynamic row format.
     */
    const ROW_FORMAT_DYNAMIC = 'DYNAMIC';

    /**
     * MySQL keyword for the table fixed row format.
     */
    const ROW_FORMAT_FIXED = 'FIXED';

    /**
     * MySQL keyword for the table compressed row format.
     */
    const ROW_FORMAT_COMPRESSED = 'COMPRESSED';

    /**
     * MySQL keyword for the table redundant row format.
     */
    const ROW_FORMAT_REDUNDANT = 'REDUNDANT';

    /**
     * MySQL keyword for the table compact row format.
     */
    const ROW_FORMAT_COMPACT = 'COMPACT';

    /**
     * Get the table name.
     * @return string Table name.
     */
    public function getName();

    /**
     * Set the table name.
     * @param string $name Table name.
     */
    public function setName($name);

    /**
     * Get the database name.
     * @return string Database name.
     */
    public function getDatabaseName();

    /**
     * Indicates if a database name is set for the table.
     * @return bool Returns true if table has a database name set.
     */
    public function hasDatabaseName();

    /**
     * Set the database name for the table.
     * @param string $databaseName Database name.
     */
    public function setDatabaseName($databaseName);

    /**
     * Get the names of all columns in the table.
     * @return array Column names.
     */
    public function getColumnList();

    /**
     * Get all the columns for the table.
     * @return ColumnInterface[] Columns
     */
    public function getColumns();

    /**
     * Identify if a column with the supplied name exists in the table.
     * @param string $columnName Column name.
     * @return bool Returns true if the a column exists with the supplied name.
     */
    public function hasColumn($columnName);

    /**
     * Get a column by its name.
     * @param string $columnName Column name
     * @return ColumnInterface Returns the column for the supplied name, or
     * NULL if the column does not exist.
     */
    public function getColumn($columnName);

    /**
     * Set the columns for the table.
     * @param ColumnInterface[] $columns Array of columns for the table.
     */
    public function setColumns(array $columns);

    /**
     * Add a column to the table.
     * @param ColumnInterface $column Column to add.
     */
    public function addColumn(ColumnInterface $column);

    /**
     * Get the names of all indexes on the table.
     * @return array Index names.
     */
    public function getIndexList();

    /**
     * Get the indexes on the table.
     * @return IndexInterface[] Array of indexes.
     */
    public function getIndexes();

    /**
     * Identify if the table has an index with the given name.
     * @param string $indexName The name of the index to look for.
     * @return bool mixed True if the named index is found.
     */
    public function hasIndex($indexName);

    /**
     * Gets an index by it's name.
     * @param string $indexName The index name.
     * @return IndexInterface The index.
     */
    public function getIndex($indexName);

    /**
     * Set all indexes on the table.
     * @param ConstraintInterface[] $indexes Array of indexes to set.
     */
    public function setIndexes(array $indexes);

    /**
     * Add an index on the table.
     * @param ConstraintInterface $index The index to add.
     */
    public function addIndex(ConstraintInterface $index);

    /**
     * Indicates if the table has a primary key.
     * @return bool True if a primary key exists.
     */
    public function hasPrimaryKey();

    /**
     * Gets the primary key for the table.
     * @return PrimaryKey The primary key.  Null if a primary key does not exists.
     */
    public function getPrimaryKey();

    /**
     * Returns the names of the foreign keys on the table.
     * @return array Foreign key names.
     */
    public function getForeignKeyList();

    /**
     * Get all the foreign keys on the table.
     * @return ForeignKeyInterface[] Array of foreign keys.
     */
    public function getForeignKeys();

    /**
     * Get a foreign key by its name.
     * @param string $foreignKeyName The name of the foreign key to get.
     * @return ForeignKeyInterface
     */
    public function getForeignKey($foreignKeyName);

    /**
     * Identify if the table has a foreign key with the supplied name.
     * @param string $foreignKeyName The name of the foreign key to check for.
     * @return bool True if the named foreign key exists.
     */
    public function hasForeignKey($foreignKeyName);

    /**
     * Set the foreign keys on the table.
     * @param ForeignKeyInterface[] $foreignKeys Foreign keys to set.
     */
    public function setForeignKeys(array $foreignKeys);

    /**
     * Add a foreign key to the table.
     * @param ForeignKeyInterface $foreignKey Foreign key to add.
     */
    public function addForeignKey(ForeignKeyInterface $foreignKey);

    /**
     * Get the table engine.
     * @return string The table engine, or NULL if it has not been set.
     */
    public function getEngine();

    /**
     * Indicates if the table has an engine specified.
     * @return bool True if an engine is specified.
     */
    public function hasEngine();

    /**
     * Set the table engine.
     * @param string $engine The table engine.
     */
    public function setEngine($engine);

    /**
     * Get the default collation for the table.
     * @return string The default collation, or null if a collation is not set.
     */
    public function getDefaultCollation();

    /**
     * Indicates if the default collation is set for the table.
     * @return bool True if the collation is set.
     */
    public function hasDefaultCollation();

    /**
     * Set the default collation for the table.
     * @param string $defaultCollation The default collation.
     */
    public function setDefaultCollation($defaultCollation);

    /**
     * Get the row format for the table.
     * @return string The row format, null if the row format is not set.
     */
    public function getRowFormat();

    /**
     * Indicates if the table has the row format specified.
     * @return bool True if the row format is set.
     */
    public function hasRowFormat();

    /**
     * Set the row format on the table.
     * @param string $rowFormat The row format.
     */
    public function setRowFormat($rowFormat);

    /**
     * Get the comment for the table
     * @return string The comment, or null if a comment is not set.
     */
    public function getComment();

    /**
     * Indicates if a comment is set for the table.
     * @return bool True if a comment is set.
     */
    public function hasComment();

    /**
     * Set a comment for the table
     * @param string $comment The comment.
     */
    public function setComment($comment);

    /**
     * Get the delimiter used between DDL statements.
     * @return string
     */
    public function getDDLDelimiter();

    /**
     * Set the delimiter to use between DDL statements.
     * @param string $delimiter
     */
    public function setDDLDelimiter($delimiter);

    /**
     * Identify if drop statement will be included with DDL create statement.
     * @return int Will return the value of one of the self::DDL_DROP_* constants.
     */
    public function getDDLDropPolicy();

    /**
     * Set if the DDL should include a statement to drop the database.
     * @param int $ddlDropPolicy Supply one of the self::DDL_DROP_* constants.
     */
    public function setDDLDropPolicy($ddlDropPolicy);

    /**
     * Indicates if the DDL will use the fully qualified name for the table.
     * @return bool
     */
    public function isDDLUseFullyQualifiedName();

    /**
     * Set if the DDL should use the fully qualified name for the table.
     * @param bool $useFullyQualifiedName
     */
    public function setDDLUseFullyQualifiedName($useFullyQualifiedName);

    /**
     * Get the DDL create statement for the table.
     * @return string The DDL create statement.
     */
    public function getDDL();

    /**
     * The table DDL create statement.
     * @uses TableInterface::getDDL()
     * @return string The DDL create statement.
     */
    public function __toString();
}
