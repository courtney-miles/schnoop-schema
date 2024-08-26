<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\QuoteTrait;

abstract class AbstractTimeType implements TimeTypeInterface
{
    use QuoteTrait;

    /**
     * @var int
     */
    protected $precision;

    /**
     * AbstractTimeType constructor.
     *
     * @param int $precision decimal precision
     */
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

    public function setPrecision($precision): void
    {
        $this->precision = $precision;
    }

    public function doesAllowDefault()
    {
        return true;
    }

    public function cast($value)
    {
        return $value;
    }

    public function getDDL()
    {
        return strtoupper($this->getType())
            . ($this->getPrecision() > 0 ? '(' . $this->getPrecision() . ')' : null);
    }

    public function __toString()
    {
        return $this->getDDL();
    }
}
