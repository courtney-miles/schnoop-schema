<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 11/07/16
 * Time: 4:33 PM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\QuoteNumericTrait;

class YearType implements DataTypeInterface
{
    use QuoteNumericTrait;

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_YEAR;
    }

    /**
     * @return bool
     */
    public function doesAllowDefault()
    {
        return true;
    }

    /**
     * Cast a value from MySQL to a suitable PHP type.
     * @param mixed $value
     * @return mixed
     */
    public function cast($value)
    {
        return (int)$value;
    }

    public function __toString()
    {
        return strtoupper($this->getType());
    }
}
