<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class CharType extends AbstractCharType
{
    const MAX_LENGTH = 255;

    public function __construct($length = 1)
    {
        parent::__construct($length);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_CHAR;
    }
}
