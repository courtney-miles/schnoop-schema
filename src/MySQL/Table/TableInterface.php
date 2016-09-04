<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 27/06/16
 * Time: 7:14 AM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\Table;

use MilesAsylum\SchnoopSchema\MySQL\Column\ColumnInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\ConstraintInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\ForeignKeyInterface;

interface TableInterface
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

    public function getDatabaseName();
    public function hasDatabaseName();
    public function setDatabaseName($databaseName);

    public function getColumnList();
    public function getColumns();
    public function hasColumn($columnName);
    public function getColumn($columnName);

    /**
     * @param ColumnInterface[] $columns
     */
    public function setColumns(array $columns);

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
    public function getPrimaryKey();

    public function getForeignKeyList();
    public function getForeignKeys();
    public function getForeignKey($foreignKeyName);
    public function hasForeignKey($foreignKeyName);

    /**
     * @param array $foreignKeys
     * @return ForeignKeyInterface[]
     */
    public function setForeignKeys(array $foreignKeys);

    public function addForeignKey(ForeignKeyInterface $foreignKey);

    public function __toString();

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
}
