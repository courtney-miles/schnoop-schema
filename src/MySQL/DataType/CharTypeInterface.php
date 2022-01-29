<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\CollationInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\LengthInterface;

interface CharTypeInterface extends DataTypeInterface, CollationInterface, LengthInterface
{
}
