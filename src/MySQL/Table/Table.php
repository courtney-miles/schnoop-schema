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

class Table implements TableInterface
{
    protected $name;

    /**
     * @var ColumnInterface[]
     */
    protected $columns = array();

    /**
     * @var ConstraintInterface[]
     */
    protected $constraints = [];

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
        $column->setTableName($this);
        $this->columns[$column->getName()] = $column;
    }

    public function getConstraintList()
    {
        return array_keys($this->constraints);
    }

    public function getConstraints()
    {
        return array_values($this->constraints);
    }

    public function hasConstraint($constraintName)
    {
        return isset($this->constraints[$constraintName]);
    }

    public function getConstraint($constraintName)
    {
        return $this->hasConstraint($constraintName) ? $this->constraints[$constraintName] : null;
    }

    public function setConstraints(array $constraints)
    {
        $this->constraints = [];

        foreach ($constraints as $index) {
            $this->addConstraint($index);
        }
    }

    public function addConstraint(ConstraintInterface $constraint)
    {
        $constraint->setTable($this);

        $name = $constraint->getName();

        if (strtoupper($name) == 'PRIMARY') {
            $name = strtoupper($name);
        }

        $this->constraints[$name] = $constraint;
    }

    public function hasPrimaryKey()
    {
        return $this->hasConstraint('PRIMARY');
    }

    public function getPrimaryKey()
    {
        return $this->getConstraint('PRIMARY');
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
        $this->engine = $engine;
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
        $this->rowFormat = $rowFormat;
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
        $columnDefinitions = [];
        foreach ($this->getColumns() as $column) {
            $columnDefinitions[] = '  '.(string)$column;
        }

        $indexDefinitions = [];
        foreach ($this->getConstraints() as $index) {
            $indexDefinitions[] = '  '.(string)$index;
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
                    'CREATE TABLE `' . $this->name . "` (",
                    implode(
                        ",\n",
                        array_merge($columnDefinitions, $indexDefinitions)
                    ),
                    ')',
                    implode("\n", $tableOptions),
                ]
            )
        ) . ';';
    }
}
