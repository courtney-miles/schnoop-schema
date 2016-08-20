<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class MediumTextType extends AbstractTextType
{
    const LENGTH = 16777215;

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_MEDIUMTEXT;
    }
}
