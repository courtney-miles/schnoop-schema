<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\MySQLInterface;

/**
 * Interface ConstraintColumnInterface.
 *
 * @package MilesAsylum\SchnoopSchema\MySQL\Constraint
 */
interface ConstraintColumnInterface extends MySQLInterface
{
    /**
     * Get the name of the indexed column.
     *
     * @return string column name
     */
    public function getColumnName();
}
