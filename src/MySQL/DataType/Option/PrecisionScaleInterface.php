<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

interface PrecisionScaleInterface
{
    /**
     * @return int The number of significant digits that are stored for values.
     */
    public function getPrecision();

    public function hasPrecision();

    /**
     * @return int The number of digits that can be stored following the decimal point.
     */
    public function getScale();

    public function hasScale();

    public function setPrecisionScale($precision, $scale = 0);
}
