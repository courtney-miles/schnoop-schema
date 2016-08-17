<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\Column\ColumnInterface;

interface IndexedColumnInterface
{
    const COLLATION_ASC = 'asc';

    public function getColumnName();

    public function getLength();

    public function hasLength();

    /**
     * @param int $length
     * @return mixed
     */
    public function setLength($length);

    public function getCollation();

    public function setCollation($collation);

    public function hasCollation();
}
