<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class LongTextType extends AbstractTextType
{
    const LENGTH = 4294967295;

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_LONGTEXT;
    }
}
