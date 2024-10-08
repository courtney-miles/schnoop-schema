<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class TinyTextType extends AbstractTextType
{
    public const LENGTH = 255;

    public function getType()
    {
        return self::TYPE_TINYTEXT;
    }

    public function getLength()
    {
        return self::LENGTH;
    }
}
