<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class LongTextType extends AbstractTextType
{
    const LENGTH = 4294967295;

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE_LONGTEXT;
    }

    /**
     * {@inheritdoc}
     */
    public function getLength()
    {
        return self::LENGTH;
    }
}
