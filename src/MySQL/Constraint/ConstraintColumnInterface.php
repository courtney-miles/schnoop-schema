<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\MySQLInterface;

interface ConstraintColumnInterface extends MySQLInterface
{
    /**
     * @return string
     */
    public function getColumnName();
}
