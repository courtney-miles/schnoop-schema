<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class CharType extends AbstractCharType
{
    const MAX_LENGTH = 255;

    /**
     * CharType constructor.
     * @param int $length Number of characters.
     */
    public function __construct($length = 1)
    {
        parent::__construct($length);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE_CHAR;
    }
}
