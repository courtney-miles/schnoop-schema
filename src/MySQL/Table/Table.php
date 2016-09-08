<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 2/06/16
 * Time: 5:01 PM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\Table;

use MilesAsylum\SchnoopSchema\MySQL\Column\ColumnInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\ConstraintInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\ForeignKeyInterface;

class Table implements TableInterface
{
    protected $name;

    protected $databaseName;

    /**
     * @var ColumnInterface[]
     */
    protected $columns = array();

    /**
     * @var ConstraintInterface[]
     */
    protected $indexes = [];

    /**
     * @var ForeignKeyInterface[]
     */
    protected $foreignKeys = [];

    protected $engine;

    protected $defaultCollation;

    protected $rowFormat;

    /**
     * @var string
     */
    protected $comment;

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDatabaseName()
    {
        return $this->databaseName;
    }

    public function hasDatabaseName()
    {
        return isset($this->databaseName);
    }

    /**
     * @param mixed $databaseName
     */
    public function setDatabaseName($databaseName)
    {
        $this->databaseName = $databaseName;
    }

    public function getColumnList()
    {
        return array_keys($this->columns);
    }

    /**
     * @return ColumnInterface[]
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

    public function setColumns(array $columns)
    {
        $this->columns = [];

        foreach ($columns as $column) {
            $this->addColumn($column);
        }
    }

    /**
     * @param ColumnInterface $column
     */
    public function addColumn(ColumnInterface $column)
    {
        $column->setTableName($this->name);
        $this->columns[$column->getName()] = $column;
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

    public function setIndexes(array $indexes)
    {
        $this->indexes = [];

        foreach ($indexes as $index) {
            $this->addIndex($index);
        }
    }

    public function addIndex(ConstraintInterface $index)
    {
        $name = $index->getName();

        if (strtoupper($name) == 'PRIMARY') {
            $name = strtoupper($name);
        }

        $this->indexes[$name] = $index;
        $index->setTableName($this->getName());
    }

    public function hasPrimaryKey()
    {
        return $this->hasIndex('PRIMARY');
    }

    public function getPrimaryKey()
    {
        return $this->getIndex('PRIMARY');
    }

    public function getForeignKeyList()
    {
        return array_keys($this->foreignKeys);
    }

    public function getForeignKeys()
    {
        return array_values($this->foreignKeys);
    }

    public function getForeignKey($foreignKeyName)
    {
        return $this->hasForeignKey($foreignKeyName) ? $this->foreignKeys[$foreignKeyName] : null;
    }

    public function hasForeignKey($foreignKeyName)
    {
        return isset($this->foreignKeys[$foreignKeyName]);
    }

    public function setForeignKeys(array $foreignKeys)
    {
        $this->foreignKeys = [];

        foreach ($foreignKeys as $foreignKey) {
            $this->addForeignKey($foreignKey);
        }
    }

    public function addForeignKey(ForeignKeyInterface $foreignKey)
    {
        $this->foreignKeys[$foreignKey->getName()] = $foreignKey;
        $foreignKey->setTableName($this->getName());
    }

    /**
     * @return mixed
     */
    public function getEngine()
    {
        return $this->engine;
    }

    public function hasEngine()
    {
        return !empty($this->engine);
    }

    /**
     * @param mixed $engine
     */
    public function setEngine($engine)
    {
        $this->engine = strtoupper($engine);
    }

    /**
     * @return mixed
     */
    public function getDefaultCollation()
    {
        return $this->defaultCollation;
    }

    public function hasDefaultCollation()
    {
        return !empty($this->defaultCollation);
    }

    /**
     * @param mixed $defaultCollation
     */
    public function setDefaultCollation($defaultCollation)
    {
        $this->defaultCollation = $defaultCollation;
    }

    /**
     * @return mixed
     */
    public function getRowFormat()
    {
        return $this->rowFormat;
    }

    public function hasRowFormat()
    {
        return !empty($this->rowFormat);
    }


    /**
     * @param mixed $rowFormat
     */
    public function setRowFormat($rowFormat)
    {
        $this->rowFormat = strtoupper($rowFormat);
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    public function hasComment()
    {
        return (bool)strlen($this->comment);
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function __toString()
    {
        $fullyQualifiedName = "`{$this->getName()}`";

        if ($this->hasDatabaseName()) {
            $fullyQualifiedName = "`{$this->getDatabaseName()}`." . $fullyQualifiedName;
        }

        $columnDefinitions = [];
        foreach ($this->getColumns() as $column) {
            $columnDefinitions[] = '  '.(string)$column;
        }

        $indexDefinitions = [];
        foreach ($this->getIndexes() as $index) {
            $indexDefinitions[] = '  '.(string)$index;
        }

        $foreignKeyDefinitions = [];
        foreach ($this->getForeignKeys() as $foreignKey) {
            $foreignKeyDefinitions[] = '  ' . (string)$foreignKey;
        }

        $tableOptions = array_filter(
            [
                $this->hasEngine() ? 'ENGINE = ' . strtoupper($this->getEngine()) : null,
                $this->hasDefaultCollation() ? "DEFAULT COLLATE = '" . $this->getDefaultCollation() . "'" : null,
                $this->hasRowFormat() ? 'ROW_FORMAT = ' . strtoupper($this->getRowFormat()) : null,
                $this->hasComment() ? "COMMENT = '" . addslashes($this->getComment()) . "'" : null
            ]
        );

        return implode(
            "\n",
            array_filter(
                [
                    "CREATE TABLE {$fullyQualifiedName} (",
                    implode(
                        ",\n",
                        array_merge(
                            $columnDefinitions,
                            $indexDefinitions,
                            $foreignKeyDefinitions
                        )
                    ),
                    ')',
                    implode("\n", $tableOptions),
                ]
            )
        ) . ';';
    }
}
