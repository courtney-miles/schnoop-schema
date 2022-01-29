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

    /**
     * {@inheritdoc}
     */
    public function getPrecision()
    {
        return $this->precision;
    }

    /**
     * {@inheritdoc}
     */
    public function hasPrecision()
    {
        return !empty($this->precision);
    }

    /**
     * {@inheritdoc}
     */
    public function setPrecision($precision): void
    {
        $this->precision = $precision;
    }

    /**
     * {@inheritdoc}
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

    /**
     * {@inheritdoc}
     */
    public function getDDL()
    {
        return strtoupper($this->getType())
            . ($this->getPrecision() > 0 ? '(' . $this->getPrecision() . ')' : null);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getDDL();
    }
}
