<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 19/06/16
 * Time: 10:25 AM.
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class FloatType extends AbstractNumericPointType
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE_FLOAT;
    }

    /**
     * {@inheritdoc}
     */
    public function cast($value)
    {
        return (float) $value;
    }
}
