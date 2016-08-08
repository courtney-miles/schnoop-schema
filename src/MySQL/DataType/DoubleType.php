<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 19/06/16
 * Time: 10:25 AM
 */

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