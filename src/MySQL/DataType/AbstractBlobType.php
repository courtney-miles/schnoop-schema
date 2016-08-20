<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\QuoteTrait;

abstract class AbstractBlobType implements BlobTypeInterface
{
    use QuoteTrait;

    public function doesAllowDefault()
    {
        return false;
    }

    public function __toString()
    {
        return strtoupper($this->getType());
    }

    public function cast($value)
    {
        return (string)$value;
    }
}
