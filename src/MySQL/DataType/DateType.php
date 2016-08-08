<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 11/07/16
 * Time: 4:14 PM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\QuoteStringTrait;

class DateType implements DataTypeInterface
{
    use QuoteStringTrait;

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_DATE;
    }

    /**
     * @return bool
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

    public function __toString()
    {
        return strtoupper($this->getType());
    }
}
