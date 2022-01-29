<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

class ForeignKey extends AbstractConstraint implements ForeignKeyInterface
{
    /**
     * Reference table name.
     *
     * @var string
     */
    protected $referenceTableName;

    /**
     * Foreign key columns.
     *
     * @var ForeignKeyColumnInterface[]
     */
    protected $foreignKeyColumns = [];

    /**
     * Action on deletion.
     *
     * @var string
     */
    protected $onDeleteAction;

    /**
     * Action on update.
     *
     * @var string
     */
    protected $onUpdateAction;

    /**
     * ForeignKey constructor.
     *
     * @param string $name Trigger name
     */
    public function __construct($name)
    {
        parent::__construct($name, self::CONSTRAINT_FOREIGN_KEY);
        $this->setOnDeleteAction(self::REFERENCE_ACTION_RESTRICT);
        $this->setOnUpdateAction(self::REFERENCE_ACTION_RESTRICT);
    }

    /**
     * {@inheritdoc}
     */
    public function getOnDeleteAction()
    {
        return $this->onDeleteAction;
    }

    /**
     * {@inheritdoc}
     */
    public function setOnDeleteAction($onDeleteAction): void
    {
        $this->onDeleteAction = $onDeleteAction;
    }

    /**
     * {@inheritdoc}
     */
    public function getOnUpdateAction()
    {
        return $this->onUpdateAction;
    }

    /**
     * {@inheritdoc}
     */
    public function setOnUpdateAction($onUpdateAction): void
    {
        $this->onUpdateAction = $onUpdateAction;
    }

    /**
     * {@inheritdoc}
     */
    public function getReferenceTableName()
    {
        return $this->referenceTableName;
    }

    /**
     * {@inheritdoc}
     */
    public function hasReferenceTableName()
    {
        return isset($this->referenceTableName);
    }

    /**
     * {@inheritdoc}
     */
    public function setReferenceTableName($referenceTableName): void
    {
        $this->referenceTableName = $referenceTableName;
    }

    /**
     * {@inheritdoc}
     */
    public function getColumnNames()
    {
        return array_keys($this->foreignKeyColumns);
    }

    /**
     * {@inheritdoc}
     */
    public function getReferenceColumnNames()
    {
        $fkNames = [];

        foreach ($this->foreignKeyColumns as $foreignKeyColumn) {
            $fkNames[] = $foreignKeyColumn->getReferenceColumnName();
        }

        return $fkNames;
    }

    /**
     * {@inheritdoc}
     */
    public function hasReferenceColumnName($columnName, $tableName = null)
    {
        if ($this->getReferenceTableName() !== $tableName) {
            return false;
        }

        foreach ($this->foreignKeyColumns as $foreignKeyColumn) {
            if ($foreignKeyColumn->getReferenceColumnName() == $columnName) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getForeignKeyColumns()
    {
        return array_values($this->foreignKeyColumns);
    }

    /**
     * {@inheritdoc}
     */
    public function hasForeignKeyColumns()
    {
        return !empty($this->foreignKeyColumns);
    }

    /**
     * {@inheritdoc}
     */
    public function hasForeignKeyColumn($columnName)
    {
        foreach ($this->foreignKeyColumns as $fkColumn) {
            if ($fkColumn->getColumnName() == $columnName) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function setForeignKeyColumns(array $foreignKeyColumns): void
    {
        $this->foreignKeyColumns = [];

        foreach ($foreignKeyColumns as $foreignKeyColumn) {
            $this->addForeignKeyColumn($foreignKeyColumn);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addForeignKeyColumn(ForeignKeyColumnInterface $foreignKeyColumn): void
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

        return '`' . $this->referenceTableName . '` (' . implode(',', $referenceColumnDDLs) . ')';
    }

    /**
     * {@inheritdoc}
     */
    public function getDDL()
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
                    'ON UPDATE ' . $this->getOnUpdateAction(),
                ]
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getDDL();
    }
}
