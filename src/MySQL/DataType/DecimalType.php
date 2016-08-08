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
    /**
     * DecimalType constructor.
     * @param bool $signed
     * @param int $precision
     * @param int $scale
     */
    public function __construct($signed, $precision, $scale)
    {
        parent::__construct($signed, $precision, $scale);
    }

    public function getType()
    {
        return self::TYPE_DECIMAL;
    }
    
    public function cast($value)
    {
        return (string)$value;
    }
}