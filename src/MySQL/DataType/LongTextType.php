<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class LongTextType extends AbstractTextType
{
    public const LENGTH = 4294967295;

    public function getType()
    {
        return self::TYPE_LONGTEXT;
    }

    public function getLength()
    {
        return self::LENGTH;
    }
}
