<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class DoubleType extends AbstractNumericPointType
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE_DOUBLE;
    }

    /**
     * {@inheritdoc}
     */
    public function cast($value)
    {
        return (double)$value;
    }
}
