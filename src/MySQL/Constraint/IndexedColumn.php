<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

class IndexedColumn implements IndexedColumnInterface
{
    /**
     * Column name.
     *
     * @var string
     */
    protected $columnName;

    /**
     * Index prefix length.
     *
     * @var int
     */
    protected $length;

    /**
     * Index collation.
     *
     * @var string
     */
    protected $collation;

    /**
     * IndexedColumn constructor.
     *
     * @param string $columnName column name
     */
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

    public function setCollation($collation): void
    {
        $this->collation = $collation;
    }

    public function hasCollation()
    {
        return !empty($this->collation);
    }
}
