<?php

namespace MilesAsylum\SchnoopSchema;

/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 2/06/16
 * Time: 7:29 AM
 */
abstract class AbstractTable implements TableInterface
{
    protected $name;

    /**
     * @var ColumnInterface[]
     */
    protected $columns = array();

    /**
     * @var IndexInterface[]
     */
    protected $indexes = array();

    /**
     * AbstractTable constructor.
     * @param $name
     * @param ColumnInterface[] $columns
     * @param IndexInterface[] $indexes
     */
    public function __construct($name, array $columns, array $indexes)
    {
        $this->name = $name;
        $this->setColumns($columns);
        $this->setIndexes($indexes);
    }
    
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    public function getColumnList()
    {
        return array_keys($this->columns);
    }

    /**
     * @return AbstractColumn[]
     */
    public function getColumns()
    {
        return array_values($this->columns);
    }

    public function hasColumn($columnName)
    {
        return isset($this->columns[$columnName]);
    }

    public function getColumn($columnName)
    {
        return $this->hasColumn($columnName) ? $this->columns[$columnName] : null;
    }

    public function getIndexList()
    {
        return array_keys($this->indexes);
    }

    public function getIndexes()
    {
        return array_values($this->indexes);
    }

    public function hasIndex($indexName)
    {
        return isset($this->indexes[$indexName]);
    }

    public function getIndex($indexName)
    {
        return $this->hasIndex($indexName) ? $this->indexes[$indexName] : null;
    }

    public function hasPrimaryKey()
    {
        return $this->hasIndex('PRIMARY');
    }

    public function getPrimaryKey()
    {
        return $this->getIndex('PRIMARY');
    }

    /**
     * @param ColumnInterface[] $columns
     */
    protected function setColumns(array $columns)
    {
        $this->columns = [];

        foreach ($columns as $column) {
            $this->addColumn($column);
        }
    }
    
    /**
     * @param ColumnInterface $column
     */
    protected function addColumn(ColumnInterface $column)
    {
        $column->setTable($this);
        $this->columns[$column->getName()] = $column;
    }

    /**
     * @param IndexInterface[] $indexes
     */
    protected function setIndexes(array $indexes)
    {
        $this->indexes = [];

        foreach ($indexes as $index) {
            $this->addIndex($index);
        }
    }

    protected function addIndex(IndexInterface $index)
    {
        $this->indexes[$index->getName()] = $index;
    }
}
