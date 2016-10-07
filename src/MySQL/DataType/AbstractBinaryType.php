<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 26/06/16
 * Time: 5:05 PM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\QuoteTrait;

abstract class AbstractBinaryType implements BinaryTypeInterface
{
    use QuoteTrait;

    /**
     * @var int
     */
    private $length;

    /**
     * {@inheritdoc}
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * {@inheritdoc}
     */
    public function hasLength()
    {
        return !empty($this->length);
    }

    /**
     * {@inheritdoc}
     */
    public function setLength($length)
    {
        $this->length = (int)$length;
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
        return (string)$value;
    }

    public function getDDL()
    {
        return strtoupper($this->getType())
            . ($this->length > 0 ? '(' . $this->length . ')' : null);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getDDL();
    }
}
