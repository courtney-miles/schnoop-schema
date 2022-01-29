<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class LongTextType extends AbstractTextType
{
    public const LENGTH = 4294967295;

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
