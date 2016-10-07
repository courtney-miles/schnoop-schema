<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class MediumTextType extends AbstractTextType
{
    const LENGTH = 16777215;

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE_MEDIUMTEXT;
    }

    /**
     * {@inheritdoc}
     */
    public function getLength()
    {
        return self::LENGTH;
    }
}
