<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

class ForeignKeyColumn implements ForeignKeyColumnInterface
{
    /**
     * Column name
     * @var
     */
    protected $columnName;

    /**
     * Reference column name.
     * @var
     */
    protected $referenceColumnName;

    /**
     * ForeignKeyColumn constructor.
     * @param string $columnName Name of indexed column.
     * @param string $referenceColumnName Name of reference column.
     */
    public function __construct($columnName, $referenceColumnName)
    {
        $this->columnName = $columnName;
        $this->referenceColumnName = $referenceColumnName;
    }

    /**
     * {@inheritdoc}
     */
    public function getColumnName()
    {
        return $this->columnName;
    }

    /**
     * {@inheritdoc}
     */
    public function getReferenceColumnName()
    {
        return $this->referenceColumnName;
    }
}
