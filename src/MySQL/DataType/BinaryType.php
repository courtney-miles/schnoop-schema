<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class BinaryType extends AbstractBinaryType
{
    const MAX_LENGTH = 255;

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_BINARY;
    }
}
