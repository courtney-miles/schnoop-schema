<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\Table;

use MilesAsylum\SchnoopSchema\MySQL\Column\ColumnInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\ConstraintInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\ForeignKeyInterface;
use MilesAsylum\SchnoopSchema\MySQL\Exception\FQNException;

class Table implements TableInterface
{
    /**
     * Table name.
     *
     * @var string
     */
    protected $name;

    /**
     * Database name.
     *
     * @var string
     */
    protected $databaseName;

    /**
     * Columns.
     *
     * @var ColumnInterface[]
     */
    protected $columns = [];

    /**
     * Indexes.
     *
     * @var ConstraintInterface[]
     */
    protected $indexes = [];

    /**
     * Foreign keys.
     *
     * @var ForeignKeyInterface[]
     */
    protected $foreignKeys = [];

    /**
     * Table engine.
     *
     * @var string
     */
    protected $engine;

    /**
     * Default collation.
     */
    protected $defaultCollation;

    /**
     * Table row format.
     *
     * @var string
     */
    protected $rowFormat;

    /**
     * Table comment.
     *
     * @var string
     */
    protected $comment;

    /**
     * The delimiter to use between statements.
     *
     * @var string
     */
    protected $ddlDelimiter = self::DEFAULT_DELIMITER;

    /**
     * Whether to include a drop statement with the create statement.
     *
     * @var bool
     */
    protected $ddlDropPolicy = self::DDL_DROP_POLICY_DO_NOT_DROP;

    /**
     * Whether the DDL will use the fully qualified name for resources.
     *
     * @var bool
     */
    protected $ddlUseFullyQualifiedName = false;

    /**
     * Table constructor.
     *
     * @param $name string The table name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getDatabaseName()
    {
        return $this->databaseName;
    }

    public function hasDatabaseName()
    {
        return isset($this->databaseName);
    }

    public function setDatabaseName($databaseName): void
    {
        $this->databaseName = $databaseName;
    }

    public function getColumnList()
    {
        return array_keys($this->columns);
    }

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

    public function setColumns(array $columns): void
    {
        $this->columns = [];

        foreach ($columns as $column) {
            $this->addColumn($column);
        }
    }

    public function addColumn(ColumnInterface $column): void
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

    public function setIndexes(array $indexes): void
    {
        $this->indexes = [];

        foreach ($indexes as $index) {
            $this->addIndex($index);
        }
    }

    public function addIndex(ConstraintInterface $index): void
    {
        $name = $index->getName();

        if ('PRIMARY' == strtoupper($name)) {
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

    public function setForeignKeys(array $foreignKeys): void
    {
        $this->foreignKeys = [];

        foreach ($foreignKeys as $foreignKey) {
            $this->addForeignKey($foreignKey);
        }
    }

    public function addForeignKey(ForeignKeyInterface $foreignKey): void
    {
        $this->foreignKeys[$foreignKey->getName()] = $foreignKey;
        $foreignKey->setTableName($this->getName());
    }

    public function getEngine()
    {
        return $this->engine;
    }

    public function hasEngine()
    {
        return !empty($this->engine);
    }

    public function setEngine($engine): void
    {
        $this->engine = strtoupper($engine);
    }

    public function getDefaultCollation()
    {
        return $this->defaultCollation;
    }

    public function hasDefaultCollation()
    {
        return !empty($this->defaultCollation);
    }

    public function setDefaultCollation($defaultCollation): void
    {
        $this->defaultCollation = $defaultCollation;
    }

    public function getRowFormat()
    {
        return $this->rowFormat;
    }

    public function hasRowFormat()
    {
        return !empty($this->rowFormat);
    }

    public function setRowFormat($rowFormat): void
    {
        $this->rowFormat = strtoupper($rowFormat);
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function hasComment()
    {
        return null !== $this->comment && '' !== $this->comment;
    }

    public function setComment($comment): void
    {
        $this->comment = $comment;
    }

    public function getDelimiter()
    {
        return $this->ddlDelimiter;
    }

    public function setDelimiter($delimiter): void
    {
        $this->ddlDelimiter = $delimiter;
    }

    public function getDropPolicy()
    {
        return $this->ddlDropPolicy;
    }

    public function setDropPolicy($ddlDropPolicy): void
    {
        $this->ddlDropPolicy = $ddlDropPolicy;
    }

    public function useFullyQualifiedName()
    {
        return $this->ddlUseFullyQualifiedName;
    }

    public function setUseFullyQualifiedName($useFullyQualifiedName): void
    {
        $this->ddlUseFullyQualifiedName = $useFullyQualifiedName;
    }

    public function getCreateStatement()
    {
        $dropDDL = $createDDL = '';

        if ($this->ddlUseFullyQualifiedName) {
            if (!$this->hasDatabaseName()) {
                throw new FQNException('Unable to create DDL with fully-qualified-name because the database name has not been set.');
            }

            $tableName = "`{$this->getDatabaseName()}`.`{$this->getName()}`";
        } else {
            $tableName = "`{$this->getName()}`";
        }

        if ($this->ddlDropPolicy) {
            switch ($this->ddlDropPolicy) {
                case self::DDL_DROP_POLICY_DROP:
                    $dropDDL = <<<SQL
DROP TABLE {$tableName}{$this->ddlDelimiter}
SQL;
                    break;
                case self::DDL_DROP_POLICY_DROP_IF_EXISTS:
                    $dropDDL = <<<SQL
DROP TABLE IF EXISTS {$tableName}{$this->ddlDelimiter}
SQL;
                    break;
            }
        }

        $columnDefinitions = [];
        foreach ($this->getColumns() as $column) {
            $columnDefinitions[] = '  ' . (string) $column;
        }

        $indexDefinitions = [];
        foreach ($this->getIndexes() as $index) {
            $indexDefinitions[] = '  ' . (string) $index;
        }

        $foreignKeyDefinitions = [];
        foreach ($this->getForeignKeys() as $foreignKey) {
            $foreignKeyDefinitions[] = '  ' . (string) $foreignKey;
        }

        $tableOptions = array_filter(
            [
                $this->hasEngine() ? 'ENGINE = ' . strtoupper($this->getEngine()) : null,
                $this->hasDefaultCollation() ? "DEFAULT COLLATE = '" . $this->getDefaultCollation() . "'" : null,
                $this->hasRowFormat() ? 'ROW_FORMAT = ' . strtoupper($this->getRowFormat()) : null,
                $this->hasComment() ? "COMMENT = '" . addslashes($this->getComment()) . "'" : null,
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
                    $createDDL,
                ]
            )
        );

        return $createDDL;
    }

    public function __toString()
    {
        return $this->getCreateStatement();
    }
}
