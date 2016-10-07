<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class TimeType extends AbstractTimeType
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE_TIME;
    }
}
