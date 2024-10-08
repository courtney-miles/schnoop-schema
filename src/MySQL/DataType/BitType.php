<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 28/06/16
 * Time: 4:53 PM.
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\LengthTrait;
use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\QuoteTrait;

class BitType implements BitTypeInterface
{
    use LengthTrait;
    use QuoteTrait;

    public const MAX_LENGTH = 64;

    /**
     * BitType constructor.
     *
     * @param int $length number of bits
     */
    public function __construct($length = 1)
    {
        $this->setLength($length);
    }

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
        return pow(2, $this->length) - 1;
    }

    public function cast($value)
    {
        return (int) $value;
    }

    public function getDDL()
    {
        return strtoupper($this->getType()) . '(' . $this->getLength() . ')';
    }

    public function __toString()
    {
        return $this->getDDL();
    }
}
