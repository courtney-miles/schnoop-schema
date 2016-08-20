<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 28/06/16
 * Time: 4:53 PM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\LengthTrait;
use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\QuoteTrait;

class BitType implements BitTypeInterface
{
    use LengthTrait;
    use QuoteTrait;

    const MAX_LENGTH = 64;

    public function __construct($length = 1)
    {
        $this->setLength($length);
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

    public function getMinRange()
    {
        return 0;
    }

    public function getMaxRange()
    {
        return pow(2, $this->length)-1;
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    public function cast($value)
    {
        return (int)$value;
    }

    public function __toString()
    {
        return strtoupper($this->getType()) . '(' . $this->getLength() . ')';
    }
}
