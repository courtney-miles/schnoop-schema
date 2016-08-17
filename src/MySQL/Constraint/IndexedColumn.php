<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\Column\ColumnInterface;

class IndexedColumn implements IndexedColumnInterface
{
    /**
     * @var string
     */
    protected $columnName;

    /**
     * @var int
     */
    protected $length;

    /**
     * @var string
     */
    protected $collation;

    public function __construct($columnName)
    {
        $this->columnName = $columnName;
    }

    public function getColumnName()
    {
        return $this->columnName;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setLength($length)
    {
        return $this->length = $length;
    }

    public function hasLength()
    {
        return !empty($this->length);
    }

    public function getCollation()
    {
        return $this->collation;
    }

    public function setCollation($collation)
    {
        $this->collation = $collation;
    }

    public function hasCollation()
    {
        return !empty($this->collation);
    }
}
