<?php

declare(strict_types=1);

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
