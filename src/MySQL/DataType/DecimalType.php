<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class DecimalType extends AbstractNumericPointType
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE_DECIMAL;
    }

    /**
     * {@inheritdoc}
     */
    public function cast($value)
    {
        return (string) $value;
    }
}
