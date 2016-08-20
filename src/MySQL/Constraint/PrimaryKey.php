<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

class PrimaryKey extends UniqueIndex
{
    public function __construct()
    {
        parent::__construct('primary');
    }
}
