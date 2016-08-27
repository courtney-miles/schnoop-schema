<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\DisplayWidthInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\ZeroFillInterface;

interface IntTypeInterface extends NumericTypeInterface, DisplayWidthInterface, ZeroFillInterface
{
}
