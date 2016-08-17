<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\Column\ColumnInterface;
use MilesAsylum\SchnoopSchema\MySQL\Table\TableInterface as MySQLTableInterface;
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
    private $referenceTable;

    /**
     * @var ColumnInterface[]
     */
    private $referenceColumnNames = [];

    /**
     * @var string
     */
    private $onDeleteAction;

    /**
     * @var string
     */
    private $onUpdateAction;

    public function __construct($name)
    {
        parent::__construct($name, self::CONSTRAINT_FOREIGN);
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
                    strtoupper($this->getConstraintType()) . ' KEY',
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

    public function getReferenceColumnNames()
    {
        return array_values($this->referenceColumnNames);
    }

    public function setReferenceColumns(MySQLTableInterface $referenceTable, array $columnNames)
    {
        $this->referenceTable = $referenceTable;
        $this->referenceColumnNames = [];

        foreach ($columnNames as $columnName) {
//            if (!$this->referenceTable->hasColumn($columnName)) {
//                throw new UnknownColumnException(
//                    "A column named $columnName was not found in reference table, {$this->referenceTable->getName()}"
//                );
//            }

            $this->referenceColumnNames[$columnName] = $columnName;
        }
    }

    protected function makeIndexedColumnsDDL()
    {
        $columnDDLs = [];

        foreach ($this->indexedColumns as $indexedColumn) {
            $columnDDLs[] = '`' . $indexedColumn->getColumnName() . '`';
        }

        return '(' . implode(',', $columnDDLs) . ')';
    }

    protected function makeReferenceColumnDDL()
    {
        return '`' . $this->referenceTable->getName() . '` (`' . implode('`,`', $this->referenceColumnNames) . '`)';
    }
}
