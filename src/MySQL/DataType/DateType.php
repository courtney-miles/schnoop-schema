<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\QuoteTrait;

class DateType implements DataTypeInterface
{
    use QuoteTrait;

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_DATE;
    }

    public function doesAllowDefault()
    {
        return true;
    }

    public function cast($value)
    {
        return $value;
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
