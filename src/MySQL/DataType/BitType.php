<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 28/06/16
 * Time: 4:53 PM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\LengthTrait;
use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\NumericRangeTrait;

class BitType implements BitTypeInterface
{
    use LengthTrait;
    use NumericRangeTrait;

    const MAX_LENGTH = 64;

    public function __construct($length)
    {
        $this->setLength($length);
        $this->setRange(0, pow(2, $length));
    }
    
    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_BIT;
    }

    public function doesAllowDefault()
    {
        return true;
    }

    /**
     * @return mixed
     */
    public function cast($value)
    {
        return (int)$value;
    }

    public function quote($value)
    {
        return "'" . addslashes($value) . "'";
    }

    public function __toString()
    {
        return strtoupper($this->getType()) . '(' . $this->getLength() . ')';
    }
}
