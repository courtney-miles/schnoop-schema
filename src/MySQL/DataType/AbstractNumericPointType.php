<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\NumericRangeTrait;
use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\PrecisionScaleTrait;
use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\QuoteTrait;
use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\SignedTrait;

abstract class AbstractNumericPointType implements NumericPointTypeInterface
{
    use PrecisionScaleTrait;
    use SignedTrait;
    use NumericRangeTrait;
    use QuoteTrait;

    /**
     * AbstractNumericPointType constructor.
     * @param bool $signed
     * @param int $precision
     * @param int $scale
     */
    public function __construct($signed, $precision = null, $scale = null)
    {
        $this->setSigned($signed);

        if (isset($precision)) {
            $this->setPrecisionScale($precision, $scale);

            $maxRange = str_repeat('9', $precision - $scale)
                . (!empty($scale) ? '.' . str_repeat('9', $scale) : null);
            $minRange = $signed ? '-' . $maxRange : '0';
            $this->setRange($minRange, $maxRange);
        }
    }
    
    public function doesAllowDefault()
    {
        return true;
    }

    public function __toString()
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
}
