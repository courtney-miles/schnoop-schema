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

    /**
     * {@inheritdoc}
     */
    public function doesAllowDefault()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function cast($value)
    {
        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getDDL()
    {
        return strtoupper($this->getType());
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getDDL();
    }
}
