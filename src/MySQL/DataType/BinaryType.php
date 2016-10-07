<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class BinaryType extends AbstractBinaryType
{
    const MAX_LENGTH = 255;

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE_BINARY;
    }
}
