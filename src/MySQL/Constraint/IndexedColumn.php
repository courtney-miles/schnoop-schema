<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

class IndexedColumn implements IndexedColumnInterface
{
    /**
     * Column name.
     * @var string
     */
    protected $columnName;

    /**
     * Index prefix length.
     * @var int
     */
    protected $length;

    /**
     * Index collation.
     * @var string
     */
    protected $collation;

    /**
     * IndexedColumn constructor.
     * @param string $columnName Column name.
     */
    public function __construct($columnName)
    {
        $this->columnName = $columnName;
    }

    /**
     * {@inheritdoc}
     */
    public function getColumnName()
    {
        return $this->columnName;
    }

    /**
     * {@inheritdoc}
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * {@inheritdoc}
     */
    public function setLength($length)
    {
        return $this->length = $length;
    }

    /**
     * {@inheritdoc}
     */
    public function hasLength()
    {
        return !empty($this->length);
    }

    /**
     * {@inheritdoc}
     */
    public function getCollation()
    {
        return $this->collation;
    }

    /**
     * {@inheritdoc}
     */
    public function setCollation($collation)
    {
        $this->collation = $collation;
    }

    /**
     * {@inheritdoc}
     */
    public function hasCollation()
    {
        return !empty($this->collation);
    }
}
