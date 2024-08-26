<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\Column;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\MySQLInterface;

interface ColumnInterface extends MySQLInterface
{
    /**
     * MySQL keyword for the current time.
     *
     * @see http://dev.mysql.com/doc/refman/5.7/en/date-and-time-functions.html#function_current-timestamp
     */
    public const DEFAULT_CURRENT_TIMESTAMP = 'CURRENT_TIMESTAMP';

    /**
     * Get the column name.
     *
     * @return string the column name
     */
    public function getName();

    /**
     * Get the data type for the column.
     *
     * @return DataTypeInterface the data type
     */
    public function getDataType();

    /**
     * Get the name of the table the column belongs to.
     *
     * @return string the table name
     */
    public function getTableName();

    /**
     * Set the name of the table the column belongs to.
     *
     * @param string $tableName
     */
    public function setTableName($tableName);

    /**
     * Identify if a table name has been set for the column.
     *
     * @return bool returns true if the table name has been set
     */
    public function hasTableName();

    /**
     * Get the name of the database the column belongs to.
     *
     * @return string the database name
     */
    public function getDatabaseName();

    /**
     * Set the name of the database the column belongs to.
     *
     * @param string $databaseName
     */
    public function setDatabaseName($databaseName);

    /**
     * Identify if a database name has been set for the column.
     *
     * @return bool returns true if the database name has been set
     */
    public function hasDatabaseName();

    /**
     * Indicates if the column will accept a NULL value.
     *
     * @return bool returns true if the column accepts a NULL value
     */
    public function isNullable();

    /**
     * Set if the column will accept a NULL value.
     *
     * @param bool $nullable set to true to allow a NULL value
     */
    public function setNullable($nullable);

    /**
     * Indicates if the column has a default value.
     *
     * @return bool true if the column has a default value
     */
    public function hasDefault();

    /**
     * Gets the columns default value. Note that if it returns NULL, and the
     * column is not nullable, then this means there is no default value. If
     * the column is nullable and the return value is null, then the default
     * value is NULL.
     *
     * @return mixed the default value
     */
    public function getDefault();

    /**
     * Set the default value for the column.
     */
    public function setDefault($default);

    /**
     * Removes the default value for the column. If the column allows null
     * values, the default value will become NULL.
     */
    public function unsetDefault();

    /**
     * Indicates if the column value will be set to the current time on an
     * update. This only applies if the column has an appropriate date/time
     * data type.
     *
     * @return bool true if the the column will be set to the current time on
     *              an update
     */
    public function isOnUpdateCurrentTimestamp();

    /**
     * Set if the column value should be set to the current time on an update.
     * This applies only if the column has an appropriate date/time data type.
     *
     * @param bool $onUpdateCurrentTimestamp
     */
    public function setOnUpdateCurrentTimestamp($onUpdateCurrentTimestamp);

    /**
     * Get the column comment.
     *
     * @return string the comment, or null if a comment is not set
     */
    public function getComment();

    /**
     * Indicates if the column has a comment.
     *
     * @return bool true if the column has a comment
     */
    public function hasComment();

    /**
     * Set a comment for the column.
     *
     * @param string $comment
     */
    public function setComment($comment);

    /**
     * Remove the comment for the column;.
     */
    public function unsetComment();

    /**
     * Identify if the column has an auto-incrementing value.
     *
     * @return bool|null returns a boolean if the column is for a numeric
     *                   data-type, otherwise null for types that do not support this property
     */
    public function isAutoIncrement();

    /**
     * Set if the column value should auto-increment. This applies only if the
     * column has a numeric data type that support auto-incrementing.
     *
     * @param bool $autoIncrement
     */
    public function setAutoIncrement($autoIncrement);

    /**
     * Get the DDL descriptor for the column.
     *
     * @return string DDL descriptor for the column
     */
    public function getDDL();

    /**
     * @uses ColumnInterface::getDDL()
     *
     * @return string DDL descriptor for the column
     */
    public function __toString();
}
