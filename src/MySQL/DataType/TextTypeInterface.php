<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\CollationInterface;

interface TextTypeInterface extends DataTypeInterface, CollationInterface
{
    /**
     * Get the character length of the text type.
     *
     * @return int character length
     */
    public function getLength();
}
