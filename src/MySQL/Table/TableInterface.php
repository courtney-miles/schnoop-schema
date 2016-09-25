<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Table;

use MilesAsylum\SchnoopSchema\MySQL\Column\ColumnInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\ConstraintInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\ForeignKeyInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\PrimaryKey;
use MilesAsylum\SchnoopSchema\MySQL\MySQLInterface;

interface TableInterface extends MySQLInterface
{
    const ENGINE_INNODB = 'INNODB';
    const ENGINE_MEMORY = 'MEMORY';

    const ROW_FORMAT_DEFAULT = 'DEFAULT';
    const ROW_FORMAT_DYNAMIC = 'DYNAMIC';
    const ROW_FORMAT_FIXED = 'FIXED';
    const ROW_FORMAT_COMPRESSED = 'COMPRESSED';
    const ROW_FORMAT_REDUNDANT = 'REDUNDANT';
    const ROW_FORMAT_COMPACT = 'COMPACT';

    public function getName();

    /**
     * @return string
     */
    public function getDatabaseName();

    /**
     * @return bool
     */
    public function hasDatabaseName();

    /**
     * @param string $databaseName
     */
    public function setDatabaseName($databaseName);

    /**
     * Get the names of all columns in the table.
     * @return array
     */
    public function getColumnList();

    /**
     * @return ColumnInterface[]
     */
    public function getColumns();

    /**
     * @param $columnName
     * @return bool
     */
    public function hasColumn($columnName);

    /**
     * @param $columnName
     * @return ColumnInterface
     */
    public function getColumn($columnName);

    /**
     * @param ColumnInterface[] $columns
     */
    public function setColumns(array $columns);

    /**
     * @param ColumnInterface $column
     * @return mixed
     */
    public function addColumn(ColumnInterface $column);

    public function getIndexList();
    public function getIndexes();
    public function hasIndex($indexName);
    public function getIndex($indexName);

    /**
     * @param ConstraintInterface[] $indexes
     * @return mixed
     */
    public function setIndexes(array $indexes);

    public function addIndex(ConstraintInterface $index);

    public function hasPrimaryKey();

    /**
     * @return PrimaryKey
     */
    public function getPrimaryKey();

    /**
     * @return array
     */
    public function getForeignKeyList();

    /**
     * @return ForeignKeyInterface[]
     */
    public function getForeignKeys();

    /**
     * @param $foreignKeyName
     * @return ForeignKeyInterface
     */
    public function getForeignKey($foreignKeyName);

    /**
     * @param $foreignKeyName
     * @return bool
     */
    public function hasForeignKey($foreignKeyName);

    /**
     * @param array $foreignKeys
     * @return ForeignKeyInterface[]
     */
    public function setForeignKeys(array $foreignKeys);

    /**
     * @param ForeignKeyInterface $foreignKey
     * @return mixed
     */
    public function addForeignKey(ForeignKeyInterface $foreignKey);

    public function getEngine();

    public function hasEngine();

    public function setEngine($engine);

    public function getDefaultCollation();

    public function hasDefaultCollation();

    public function setDefaultCollation($defaultCollation);

    public function getRowFormat();

    public function hasRowFormat();

    public function setRowFormat($rowFormat);

    public function getComment();

    public function hasComment();

    public function setComment($comment);

    public function getDDL(
        $delimiter = self::DEFAULT_DELIMITER,
        $fullyQualifiedName = false,
        $drop = self::DDL_DROP_DO_NOT
    );

    public function __toString();
}
