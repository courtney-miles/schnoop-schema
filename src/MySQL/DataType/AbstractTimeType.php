<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\QuoteTrait;

abstract class AbstractTimeType implements TimeTypeInterface
{
    use QuoteTrait;

    protected $precision;

    public function __construct($precision = 0)
    {
        $this->setPrecision($precision);
    }

    public function getPrecision()
    {
        return $this->precision;
    }

    public function hasPrecision()
    {
        return !empty($this->precision);
    }

    public function setPrecision($precision)
    {
        $this->precision = $precision;
    }

    /**
     * @return bool
     */
    public function doesAllowDefault()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function cast($value)
    {
        return $value;
    }

    public function __toString()
    {
        return strtoupper($this->getType())
            . ($this->getPrecision() > 0 ? '(' . $this->getPrecision() . ')' : null);
    }
}
