<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\LengthInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\CollationInterface;

interface CharTypeInterface extends DataTypeInterface, CollationInterface, LengthInterface
{
}
