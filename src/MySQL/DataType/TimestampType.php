<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class TimestampType extends AbstractTimeType
{
    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_TIMESTAMP;
    }
}
