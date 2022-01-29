<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

class PrimaryKey extends UniqueIndex
{
    /**
     * PrimaryKey constructor.
     */
    public function __construct()
    {
        parent::__construct('primary');
    }
}
