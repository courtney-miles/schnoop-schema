<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

interface ForeignKeyColumnInterface extends ConstraintColumnInterface
{
    /**
     * Get the reference column name for the foreign key column.
     *
     * @return string reference column name
     */
    public function getReferenceColumnName();
}
