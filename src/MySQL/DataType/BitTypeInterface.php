<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\LengthInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\NumericRangeInterface;

interface BitTypeInterface extends DataTypeInterface, LengthInterface, NumericRangeInterface
{
}
