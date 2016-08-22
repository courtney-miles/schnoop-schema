<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\Constraint\Exception\UnknownColumnException;
use MilesAsylum\SchnoopSchema\MySQL\Exception\DBMSMismatchException;
use MilesAsylum\SchnoopSchema\MySQL\Table\TableInterface as MySQLTableInterface;
use MilesAsylum\SchnoopSchema\MySQL\Table\TableInterface;

abstract class AbstractConstraint implements ConstraintInterface
{
    /**
     * @var null
     */
    protected $name;

    protected $constraintType;

    /**
     * @var MySQLTableInterface
     */
    protected $table;

    public function __construct($name, $constraintType)
    {
        $this->name = $name;
        $this->constraintType = $constraintType;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getConstraintType()
    {
        return $this->constraintType;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function setTable(TableInterface $table)
    {
//        foreach ($this->indexedColumns as $indexedColumn) {
//            if (!$table->hasColumn($indexedColumn->getColumnName())) {
//                throw new UnknownColumnException(
//                    "A column named {$indexedColumn->getColumnName()} was not found in the table {$table->getName()}"
//                );
//            }
//        }

        $this->table = $table;
    }

    /**
     * Identify if the index has been attached to a table.
     * @return bool True if the index has been attached to a table.
     */
    public function hasTable()
    {
        return isset($this->table);
    }
}
