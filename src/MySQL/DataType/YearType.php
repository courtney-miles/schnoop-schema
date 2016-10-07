<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 11/07/16
 * Time: 4:33 PM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\QuoteTrait;

class YearType implements DataTypeInterface
{
    use QuoteTrait;

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE_YEAR;
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
        return (int)$value;
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
