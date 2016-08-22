<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

class ForeignKeyColumn implements ForeignKeyColumnInterface
{
    /**
     * @var
     */
    protected $columnName;

    /**
     * @var
     */
    protected $referenceColumnName;

    public function __construct($columnName, $referenceColumnName)
    {
        $this->columnName = $columnName;
        $this->referenceColumnName = $referenceColumnName;
    }

    public function getColumnName()
    {
        return $this->columnName;
    }

    public function getReferenceColumnName()
    {
        return $this->referenceColumnName;
    }
}
