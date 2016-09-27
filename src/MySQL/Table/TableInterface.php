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
     * @param string $name
     */
    public function setName($name);

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
     * @param string $columnName
     * @return bool
     */
    public function hasColumn($columnName);

    /**
     * @param string $columnName
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

    /**
     * @return array
     */
    public function getIndexList();

    /**
     * @return IndexInterface[]
     */
    public function getIndexes();

    /**
     * @param string $indexName
     * @return bool mixed
     */
    public function hasIndex($indexName);

    /**
     * @param string $indexName
     * @return IndexInterface
     */
    public function getIndex($indexName);

    /**
     * @param ConstraintInterface[] $indexes
     */
    public function setIndexes(array $indexes);

    /**
     * @param ConstraintInterface $index
     */
    public function addIndex(ConstraintInterface $index);

    /**
     * @return bool
     */
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
     * @param string $foreignKeyName
     * @return ForeignKeyInterface
     */
    public function getForeignKey($foreignKeyName);

    /**
     * @param string $foreignKeyName
     * @return bool
     */
    public function hasForeignKey($foreignKeyName);

    /**
     * @param ForeignKeyInterface[] $foreignKeys
     */
    public function setForeignKeys(array $foreignKeys);

    /**
     * @param ForeignKeyInterface $foreignKey
     * @return mixed
     */
    public function addForeignKey(ForeignKeyInterface $foreignKey);

    /**
     * @return string
     */
    public function getEngine();

    /**
     * @return bool
     */
    public function hasEngine();

    /**
     * @param string $engine
     */
    public function setEngine($engine);

    /**
     * @return string
     */
    public function getDefaultCollation();

    /**
     * @return bool
     */
    public function hasDefaultCollation();

    /**
     * @param string $defaultCollation
     */
    public function setDefaultCollation($defaultCollation);

    /**
     * @return string
     */
    public function getRowFormat();

    /**
     * @return bool
     */
    public function hasRowFormat();

    /**
     * @param string $rowFormat
     */
    public function setRowFormat($rowFormat);

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
     * @param string $delimiter
     * @param bool $fullyQualifiedName
     * @param int $drop
     * @return string
     */
    public function getDDL(
        $delimiter = self::DEFAULT_DELIMITER,
        $fullyQualifiedName = false,
        $drop = self::DDL_DROP_DO_NOT
    );

    /**
     * @return string
     */
    public function __toString();
}
