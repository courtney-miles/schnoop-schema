<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\QuoteTrait;

abstract class AbstractBlobType implements BlobTypeInterface
{
    use QuoteTrait;

    public function doesAllowDefault()
    {
        return false;
    }

    public function cast($value)
    {
        return (string) $value;
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
