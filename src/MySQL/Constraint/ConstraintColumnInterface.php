<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\MySQLInterface;

interface ConstraintColumnInterface extends MySQLInterface
{
    public function getColumnName();
}
