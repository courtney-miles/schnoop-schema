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

    /**
     * BitType constructor.
     * @param int $length Number of bits.
     */
    public function __construct($length = 1)
    {
        $this->setLength($length);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE_BIT;
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
    public function getMinRange()
    {
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getMaxRange()
    {
        return pow(2, $this->length)-1;
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
        return strtoupper($this->getType()) . '(' . $this->getLength() . ')';
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getDDL();
    }
}
