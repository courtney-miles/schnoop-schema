<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

trait QuoteNumericTrait
{
    public function quote($value)
    {
        return $value;
    }
}
