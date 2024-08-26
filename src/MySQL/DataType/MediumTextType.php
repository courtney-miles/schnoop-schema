<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class MediumTextType extends AbstractTextType
{
    public const LENGTH = 16777215;

    public function getType()
    {
        return self::TYPE_MEDIUMTEXT;
    }

    public function getLength()
    {
        return self::LENGTH;
    }
}
