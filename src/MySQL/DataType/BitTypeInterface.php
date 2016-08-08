<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 28/06/16
 * Time: 4:59 PM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\LengthInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\NumericRangeInterface;

interface BitTypeInterface extends DataTypeInterface, LengthInterface, NumericRangeInterface
{

}