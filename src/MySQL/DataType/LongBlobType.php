<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class LongBlobType extends AbstractBlobType
{
    const LENGTH = 4294967295;

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE_LONGBLOB;
    }
}
