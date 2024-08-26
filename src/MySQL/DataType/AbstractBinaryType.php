<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 26/06/16
 * Time: 5:05 PM.
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

    public function getLength()
    {
        return $this->length;
    }

    public function hasLength()
    {
        return !empty($this->length);
    }

    public function setLength($length): void
    {
        $this->length = (int) $length;
    }

    public function doesAllowDefault()
    {
        return true;
    }

    public function cast($value)
    {
        return (string) $value;
    }

    public function getDDL()
    {
        return strtoupper($this->getType())
            . ($this->length > 0 ? '(' . $this->length . ')' : null);
    }

    public function __toString()
    {
        return $this->getDDL();
    }
}
