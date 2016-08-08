<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 26/06/16
 * Time: 5:05 PM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\QuoteStringTrait;

abstract class AbstractBinaryType implements BinaryTypeInterface
{
    use QuoteStringTrait;

    /**
     * @var int
     */
    private $length;

    /**
     * AbstractBinaryType constructor.
     * @param int $length
     */
    public function __construct($length)
    {
        $this->setLength($length);
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param int $length
     */
    protected function setLength($length)
    {
        $this->length = (int)$length;
    }

    public function cast($value)
    {
        return (string)$value;
    }

    public function __toString()
    {
        return strtoupper($this->getType())
        . ($this->length > 0 ? '(' . $this->length . ')' : null);
    }
}
