<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class EnumType extends AbstractOptionsType
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE_ENUM;
    }
}
