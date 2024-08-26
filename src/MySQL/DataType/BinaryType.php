<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class BinaryType extends AbstractBinaryType
{
    public const MAX_LENGTH = 255;

    public function getType()
    {
        return self::TYPE_BINARY;
    }
}
