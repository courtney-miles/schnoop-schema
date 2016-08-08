<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

trait QuoteStringTrait
{
    public function quote($value)
    {
        return "'" . addslashes($value) . "'";
    }
}
