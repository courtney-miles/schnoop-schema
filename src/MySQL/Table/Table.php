<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Table;

use MilesAsylum\SchnoopSchema\MySQL\Column\ColumnInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\ConstraintInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\ForeignKeyInterface;
use MilesAsylum\SchnoopSchema\MySQL\Exception\FQNException;

class Table implements TableInterface
{
    /**
     * Table name.
     * @var string
     */
    protected $name;

    /**
     * Database name.
     * @var string
     */
    protected $databaseName;

    /**
     * Columns.
     * @var ColumnInterface[]
     */
    protected $columns = array();

    /**
     * Indexes.
     * @var ConstraintInterface[]
     */
    protected $indexes = [];

    /**
     * Foreign keys.
     * @var ForeignKeyInterface[]
     */
    protected $foreignKeys = [];

    /**
     * Table engine.
     * @var string
     */
    protected $engine;

    /**
     * Default collation.
     * @var
     */
    protected $defaultCollation;

    /**
     * Table row format.
     * @var string
     */
    protected $rowFormat;

    /**
     * Table comment.
     * @var string
     */
    protected $comment;

    /**
     * The delimiter to use between statements.
     * @var string
     */
    protected $ddlDelimiter = self::DEFAULT_DELIMITER;

    /**
     * Whether to include a drop statement with the create statement.
     * @var bool
     */
    protected $ddlDropPolicy = self::DDL_DROP_DO_NOT;

    /**
     * Whether the DDL will use the fully qualified name for resources.
     * @var bool
     */
    protected $ddlUseFullyQualifiedName = false;

    /**
     * Table constructor.
     * @param $name string The table name.
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getDatabaseName()
    {
        return $this->databaseName;
    }

    /**
     * {@inheritdoc}
     */
    public function hasDatabaseName()
    {
        return isset($this->databaseName);
    }

    /**
     * {@inheritdoc}
     */
    public function setDatabaseName($databaseName)
    {
        $this->databaseName = $databaseName;
    }

    /**
     * {@inheritdoc}
     */
    public function getColumnList()
    {
        return array_keys($this->columns);
    }

    /**
     * {@inheritdoc}
     */
    public function getColumns()
    {
        return array_values($this->columns);
    }

    /**
     * {@inheritdoc}
     */
    public function hasColumn($columnName)
    {
        return isset($this->columns[$columnName]);
    }

    /**
     * {@inheritdoc}
     */
    public function getColumn($columnName)
    {
        return $this->hasColumn($columnName) ? $this->columns[$columnName] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function setColumns(array $columns)
    {
        $this->columns = [];

        foreach ($columns as $column) {
            $this->addColumn($column);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addColumn(ColumnInterface $column)
    {
        $column->setTableName($this->name);
        $this->columns[$column->getName()] = $column;
    }

    /**
     * {@inheritdoc}
     */
    public function getIndexList()
    {
        return array_keys($this->indexes);
    }

    /**
     * {@inheritdoc}
     */
    public function getIndexes()
    {
        return array_values($this->indexes);
    }

    /**
     * {@inheritdoc}
     */
    public function hasIndex($indexName)
    {
        return isset($this->indexes[$indexName]);
    }

    /**
     * {@inheritdoc}
     */
    public function getIndex($indexName)
    {
        return $this->hasIndex($indexName) ? $this->indexes[$indexName] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function setIndexes(array $indexes)
    {
        $this->indexes = [];

        foreach ($indexes as $index) {
            $this->addIndex($index);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addIndex(ConstraintInterface $index)
    {
        $name = $index->getName();

        if (strtoupper($name) == 'PRIMARY') {
            $name = strtoupper($name);
        }

        $this->indexes[$name] = $index;
        $index->setTableName($this->getName());
    }

    /**
     * {@inheritdoc}
     */
    public function hasPrimaryKey()
    {
        return $this->hasIndex('PRIMARY');
    }

    /**
     * {@inheritdoc}
     */
    public function getPrimaryKey()
    {
        return $this->getIndex('PRIMARY');
    }

    /**
     * {@inheritdoc}
     */
    public function getForeignKeyList()
    {
        return array_keys($this->foreignKeys);
    }

    /**
     * {@inheritdoc}
     */
    public function getForeignKeys()
    {
        return array_values($this->foreignKeys);
    }

    /**
     * {@inheritdoc}
     */
    public function getForeignKey($foreignKeyName)
    {
        return $this->hasForeignKey($foreignKeyName) ? $this->foreignKeys[$foreignKeyName] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function hasForeignKey($foreignKeyName)
    {
        return isset($this->foreignKeys[$foreignKeyName]);
    }

    /**
     * {@inheritdoc}
     */
    public function setForeignKeys(array $foreignKeys)
    {
        $this->foreignKeys = [];

        foreach ($foreignKeys as $foreignKey) {
            $this->addForeignKey($foreignKey);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addForeignKey(ForeignKeyInterface $foreignKey)
    {
        $this->foreignKeys[$foreignKey->getName()] = $foreignKey;
        $foreignKey->setTableName($this->getName());
    }

    /**
     * {@inheritdoc}
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * {@inheritdoc}
     */
    public function hasEngine()
    {
        return !empty($this->engine);
    }

    /**
     * {@inheritdoc}
     */
    public function setEngine($engine)
    {
        $this->engine = strtoupper($engine);
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultCollation()
    {
        return $this->defaultCollation;
    }

    /**
     * {@inheritdoc}
     */
    public function hasDefaultCollation()
    {
        return !empty($this->defaultCollation);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultCollation($defaultCollation)
    {
        $this->defaultCollation = $defaultCollation;
    }

    /**
     * {@inheritdoc}
     */
    public function getRowFormat()
    {
        return $this->rowFormat;
    }

    /**
     * {@inheritdoc}
     */
    public function hasRowFormat()
    {
        return !empty($this->rowFormat);
    }

    /**
     * {@inheritdoc}
     */
    public function setRowFormat($rowFormat)
    {
        $this->rowFormat = strtoupper($rowFormat);
    }

    /**
     * {@inheritdoc}
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * {@inheritdoc}
     */
    public function hasComment()
    {
        return (bool)strlen($this->comment);
    }

    /**
     * {@inheritdoc}
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * {@inheritdoc}
     */
    public function getDDLDelimiter()
    {
        return $this->ddlDelimiter;
    }

    /**
     * {@inheritdoc}
     */
    public function setDDLDelimiter($delimiter)
    {
        $this->ddlDelimiter = $delimiter;
    }

    /**
     * {@inheritdoc}
     */
    public function getDDLDropPolicy()
    {
        return $this->ddlDropPolicy;
    }

    /**
     * {@inheritdoc}
     */
    public function setDDLDropPolicy($ddlDropPolicy)
    {
        $this->ddlDropPolicy = $ddlDropPolicy;
    }

    /**
     * {@inheritdoc}
     */
    public function isDDLUseFullyQualifiedName()
    {
        return $this->ddlUseFullyQualifiedName;
    }

    /**
     * {@inheritdoc}
     */
    public function setDDLUseFullyQualifiedName($useFullyQualifiedName)
    {
        $this->ddlUseFullyQualifiedName = $useFullyQualifiedName;
    }

    /**
     * {@inheritdoc}
     */
    public function getDDL()
    {
        $dropDDL = $createDDL = '';

        if ($this->ddlUseFullyQualifiedName) {
            if (!$this->hasDatabaseName()) {
                throw new FQNException(
                    'Unable to create DDL with fully-qualified-name because the database name has not been set.'
                );
            }

            $tableName = "`{$this->getDatabaseName()}`.`{$this->getName()}`";
        } else {
            $tableName = "`{$this->getName()}`";
        }

        if ($this->ddlDropPolicy) {
            switch ($this->ddlDropPolicy) {
                case self::DDL_DROP_DOES_EXISTS:
                    $dropDDL = <<<SQL
DROP TABLE {$tableName}{$this->ddlDelimiter}
SQL;
                    break;
                case self::DDL_DROP_IF_EXISTS:
                    $dropDDL = <<<SQL
DROP TABLE IF EXISTS {$tableName}{$this->ddlDelimiter}
SQL;
                    break;
            }
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

        $createDDL = implode(
            "\n",
            array_filter(
                [
                    "CREATE TABLE {$tableName} (",
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
        ) . $this->ddlDelimiter;

        $createDDL = implode(
            "\n",
            array_filter(
                [
                    $dropDDL,
                    $createDDL
                ]
            )
        );

        return $createDDL;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getDDL();
    }
}
