<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class TimeType extends AbstractTimeType
{
    public function getType()
    {
        return self::TYPE_TIME;
    }
}
