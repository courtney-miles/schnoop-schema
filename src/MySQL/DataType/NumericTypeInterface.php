<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\NumericRangeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\SignedInterface;

interface NumericTypeInterface extends DataTypeInterface, NumericRangeInterface, SignedInterface
{
}
