<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 19/06/16
 * Time: 9:15 AM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

interface PrecisionScaleInterface
{
    /**
     * @return int The number of significant digits that are stored for values.
     */
    public function getPrecision();

    /**
     * @return int The number of digits that can be stored following the decimal point.
     */
    public function getScale();
}