<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 19/06/16
 * Time: 10:18 AM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class DecimalType extends AbstractNumericPointType
{
    public function getType()
    {
        return self::TYPE_DECIMAL;
    }
    
    public function cast($value)
    {
        return (string)$value;
    }
}
