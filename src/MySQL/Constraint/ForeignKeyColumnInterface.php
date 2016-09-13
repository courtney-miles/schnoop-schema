<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

interface ForeignKeyColumnInterface extends ConstraintColumnInterface
{
    public function getColumnName();
    
    public function getReferenceColumnName();
}
