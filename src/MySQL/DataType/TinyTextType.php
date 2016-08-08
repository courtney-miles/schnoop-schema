<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class TinyTextType extends AbstractTextType
{
    const LENGTH = 255;

    public function __construct($collation = null)
    {
        parent::__construct(self::LENGTH, $collation);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_TINYTEXT;
    }
}
