<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\CollationInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\OptionsInterface;

interface OptionsTypeInterface extends DataTypeInterface, OptionsInterface, CollationInterface
{
}
