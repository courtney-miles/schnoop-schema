<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class TimeType extends AbstractTimeType
{
    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_TIME;
    }
}
