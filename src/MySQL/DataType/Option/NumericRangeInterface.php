<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

interface NumericRangeInterface
{
    /**
     * Get the minimum value the type accepts.
     *
     * @return int minimum value
     */
    public function getMinRange();

    /**
     * Get the maximum value the type accepts.
     *
     * @return int maximum value
     */
    public function getMaxRange();
}
