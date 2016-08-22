<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

interface ForeignKeyColumnInterface extends ConstraintColumnInterface
{
    public function getReferenceColumnName();
}
