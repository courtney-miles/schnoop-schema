<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class DoubleType extends AbstractNumericPointType
{
    public function getType()
    {
        return self::TYPE_DOUBLE;
    }

    public function cast($value)
    {
        return (double)$value;
    }
}
