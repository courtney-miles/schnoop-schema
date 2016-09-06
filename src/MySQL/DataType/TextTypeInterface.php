<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\CollationInterface;

interface TextTypeInterface extends DataTypeInterface, CollationInterface
{
    public function getLength();
}
