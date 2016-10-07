<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\CollationInterface;

interface TextTypeInterface extends DataTypeInterface, CollationInterface
{
    /**
     * Get the character length of the text type.
     * @return int Character length.
     */
    public function getLength();
}
