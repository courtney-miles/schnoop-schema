<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\Column\ColumnInterface;
use MilesAsylum\SchnoopSchema\MySQL\Table\TableInterface;

class ForeignKey extends AbstractConstraint implements ForeignKeyInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var TableInterface
     */
    protected $referenceTable;

    /**
     * @var ForeignKeyColumnInterface[]
     */
    protected $foreignKeyColumns = [];

    /**
     * @var string
     */
    protected $onDeleteAction;

    /**
     * @var string
     */
    protected $onUpdateAction;

    public function __construct($name)
    {
        parent::__construct($name, self::CONSTRAINT_FOREIGN_KEY);
        $this->setOnDeleteAction(self::REFERENCE_ACTION_RESTRICT);
        $this->setOnUpdateAction(self::REFERENCE_ACTION_RESTRICT);
    }

    public function __toString()
    {
        return implode(
            ' ',
            array_filter(
                [
                    'CONSTRAINT `' . $this->getName() . '`',
                    strtoupper($this->getConstraintType()),
                    $this->makeIndexedColumnsDDL(),
                    'REFERENCES',
                    $this->makeReferenceColumnDDL(),
                    'ON DELETE ' . $this->getOnDeleteAction(),
                    'ON UPDATE ' . $this->getOnUpdateAction()
                ]
            )
        );
    }

    public function getOnDeleteAction()
    {
        return $this->onDeleteAction;
    }

    public function setOnDeleteAction($onDeleteAction)
    {
        $this->onDeleteAction = $onDeleteAction;
    }

    public function getOnUpdateAction()
    {
        return $this->onUpdateAction;
    }

    public function setOnUpdateAction($onUpdateAction)
    {
        $this->onUpdateAction = $onUpdateAction;
    }

    public function getReferenceTable()
    {
        return $this->referenceTable;
    }

    public function hasReferenceTable()
    {
        return isset($this->referenceTable);
    }

    public function setReferenceTable(TableInterface $referenceTable)
    {
        $this->referenceTable = $referenceTable;
    }

    public function getColumnNames()
    {
        return array_keys($this->foreignKeyColumns);
    }

    public function getReferenceColumnNames()
    {
        $fkNames = [];

        foreach ($this->foreignKeyColumns as $foreignKeyColumn) {
            $fkNames[] = $foreignKeyColumn->getReferenceColumnName();
        }

        return $fkNames;
    }

    public function getForeignKeyColumns()
    {
        return array_values($this->foreignKeyColumns);
    }

    public function hasForeignKeyColumns()
    {
        return !empty($this->foreignKeyColumns);
    }

    public function setForeignKeyColumns(array $foreignKeyColumns)
    {
        $this->foreignKeyColumns = [];

        foreach ($foreignKeyColumns as $foreignKeyColumn) {
            $this->addForeignKeyColumn($foreignKeyColumn);
        }
    }

    public function addForeignKeyColumn(ForeignKeyColumnInterface $foreignKeyColumn)
    {
        $this->foreignKeyColumns[$foreignKeyColumn->getColumnName()] = $foreignKeyColumn;
    }

    protected function makeIndexedColumnsDDL()
    {
        $columnDDLs = [];

        foreach ($this->foreignKeyColumns as $foreignKeyColumn) {
            $columnDDLs[] = '`' . $foreignKeyColumn->getColumnName() . '`';
        }

        return '(' . implode(',', $columnDDLs) . ')';
    }

    protected function makeReferenceColumnDDL()
    {
        $referenceColumnDDLs = [];

        foreach ($this->foreignKeyColumns as $foreignKeyColumn) {
            $referenceColumnDDLs[] = '`' . $foreignKeyColumn->getReferenceColumnName() . '`';
        }

        return '`' . $this->referenceTable->getName() . '` (' . implode(',', $referenceColumnDDLs) . ')';
    }
}