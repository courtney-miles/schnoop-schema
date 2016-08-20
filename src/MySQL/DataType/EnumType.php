<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class EnumType extends AbstractOptionsType
{
    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_ENUM;
    }
}
