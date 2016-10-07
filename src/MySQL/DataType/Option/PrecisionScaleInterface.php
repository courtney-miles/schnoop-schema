<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

interface PrecisionScaleInterface
{
    /**
     * Get the precision (number of significant digits) that are stored for values.
     * @return int Precision.
     */
    public function getPrecision();

    /**
     * Identify if the precision (number of significant digits) is set.
     * @return bool True if precision is set.
     */
    public function hasPrecision();

    /**
     * Get the scale (number of decimal places) used to store the value.
     * @return int Scale (decimal places.)
     */
    public function getScale();

    /**
     * Identify if a scale (number of decimal places) is set, or not zero.
     * @return bool True if the scale is set and is not zero.
     */
    public function hasScale();

    /**
     * Set the precision (number of significant digits) and scale (number of decimal places).
     * @param int $precision Number of significant digits.
     * @param int $scale Number of decimal places
     */
    public function setPrecisionScale($precision, $scale = 0);
}
