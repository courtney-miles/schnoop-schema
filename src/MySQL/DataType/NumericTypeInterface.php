<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\NumericRangeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\SignedInterface;

interface NumericTypeInterface extends DataTypeInterface, NumericRangeInterface, SignedInterface
{
}
