<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

interface NumericRangeInterface
{
    /**
     * Get the minimum value the type accepts.
     * @return int Minimum value.
     */
    public function getMinRange();

    /**
     * Get the maximum value the type accepts.
     * @return int Maximum value.
     */
    public function getMaxRange();
}
