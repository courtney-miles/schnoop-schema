<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Column;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;

interface ColumnInterface
{
    public function getName();

    /**
     * @return DataTypeInterface
     */
    public function getDataType();

    /**
     * @return string
     */
    public function getTableName();

    public function setTableName($tableName);

    /**
     * @return bool
     */
    public function hasTableName();

    public function __toString();

    public function getDatabaseName();

    public function setDatabaseName($databaseName);

    public function hasDatabaseName();

    /**
     * @return boolean
     */
    public function isNullable();

    /**
     * @param bool $nullable
     */
    public function setNullable($nullable);

    /**
     * @return bool
     */
    public function hasDefault();

    /**
     * @return mixed
     */
    public function getDefault();

    public function setDefault($default);

    /**
     * @return string
     */
    public function getComment();

    /**
     * @return bool
     */
    public function hasComment();

    /**
     * @param string $comment
     */
    public function setComment($comment);

    /**
     * @return bool|null Returns a boolean if the column is for a numeric
     * data-type, otherwise null for types that do not support this property.
     */
    public function isAutoIncrement();

    public function setAutoIncrement($autoIncrement);
}
