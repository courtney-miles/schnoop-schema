<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

trait QuoteTrait
{
    public function quote($value)
    {
        return is_numeric($value) ? (string)$value : "'" . addslashes($value) . "'";
    }
}
