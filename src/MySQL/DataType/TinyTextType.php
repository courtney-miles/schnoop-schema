<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class TinyTextType extends AbstractTextType
{
    const LENGTH = 255;

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE_TINYTEXT;
    }

    /**
     * {@inheritdoc}
     */
    public function getLength()
    {
        return self::LENGTH;
    }
}
