<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class LongBlobType extends AbstractBlobType
{
    const LENGTH = 4294967295;

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_LONGBLOB;
    }
}
