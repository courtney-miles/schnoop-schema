<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class LongBlobType extends AbstractBlobType
{
    public const LENGTH = 4294967295;

    public function getType()
    {
        return self::TYPE_LONGBLOB;
    }
}
