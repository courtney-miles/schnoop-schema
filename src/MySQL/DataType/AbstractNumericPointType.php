<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\PrecisionScaleTrait;
use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\QuoteTrait;
use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\SignedTrait;
use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\ZeroFillTrait;

abstract class AbstractNumericPointType implements NumericPointTypeInterface
{
    use PrecisionScaleTrait;
    use SignedTrait;
    use QuoteTrait;
    use ZeroFillTrait;

    /**
     * AbstractNumericPointType constructor.
     */
    public function __construct()
    {
        $this->setSigned(true);
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
    public function getMinRange()
    {
        $minRange = null;

        if ($this->hasPrecision()) {
            if ($this->isSigned()) {
                $minRange = '-' . str_repeat('9', $this->getPrecision() - $this->getScale())
                    . (!empty($this->getScale()) ? '.' . str_repeat('9', $this->getScale()) : null);
            } else {
                $minRange = 0;
            }
        }

        return $minRange;
    }

    /**
     * {@inheritdoc}
     */
    public function getMaxRange()
    {
        $maxRange = null;

        if ($this->hasPrecision()) {
            $maxRange = str_repeat('9', $this->getPrecision() - $this->getScale())
                . (!empty($this->getScale()) ? '.' . str_repeat('9', $this->getScale()) : null);
        }

        return $maxRange;
    }

    /**
     * {@inheritdoc}
     */
    public function getDDL()
    {
        $typeDDL = strtoupper($this->getType());

        if ($this->hasPrecision()) {
            if ($this->hasScale()) {
                $typeDDL .= '(' . $this->getPrecision() . ',' . $this->getScale() . ')';
            } else {
                $typeDDL .= '(' . $this->getPrecision() . ')';
            }
        }

        return implode(
            ' ',
            array_filter(
                [
                    $typeDDL,
                    !$this->isSigned() ? 'UNSIGNED' : null
                ]
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getDDL();
    }
}
