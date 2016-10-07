<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

interface ForeignKeyColumnInterface extends ConstraintColumnInterface
{
    /**
     * Get the reference column name for the foreign key column.
     * @return string Reference column name.
     */
    public function getReferenceColumnName();
}
