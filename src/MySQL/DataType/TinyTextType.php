<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class TinyTextType extends AbstractTextType
{
    const LENGTH = 255;

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_TINYTEXT;
    }
}
