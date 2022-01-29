<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\QuoteTrait;

abstract class AbstractBlobType implements BlobTypeInterface
{
    use QuoteTrait;

    /**
     * {@inheritdoc}
     */
    public function doesAllowDefault()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function cast($value)
    {
        return (string) $value;
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
