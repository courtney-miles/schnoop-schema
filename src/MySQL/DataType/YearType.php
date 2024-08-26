<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 11/07/16
 * Time: 4:33 PM.
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\QuoteTrait;

class YearType implements DataTypeInterface
{
    use QuoteTrait;

    public function getType()
    {
        return self::TYPE_YEAR;
    }

    public function doesAllowDefault()
    {
        return true;
    }

    public function cast($value)
    {
        return (int) $value;
    }

    public function getDDL()
    {
        return strtoupper($this->getType());
    }

    public function __toString()
    {
        return $this->getDDL();
    }
}
