<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

interface NumericRangeInterface
{
    public function getMinRange();
    
    public function getMaxRange();
}
