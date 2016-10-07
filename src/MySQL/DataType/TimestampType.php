<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class TimestampType extends AbstractTimeType
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE_TIMESTAMP;
    }
}
