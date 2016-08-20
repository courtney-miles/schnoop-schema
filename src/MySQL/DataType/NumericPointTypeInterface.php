<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 21/06/16
 * Time: 7:15 AM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\PrecisionScaleInterface;

interface NumericPointTypeInterface extends NumericTypeInterface, PrecisionScaleInterface
{
}
