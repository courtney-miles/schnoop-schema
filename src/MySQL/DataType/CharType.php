<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class CharType extends AbstractCharType
{
    public const MAX_LENGTH = 255;

    /**
     * CharType constructor.
     *
     * @param int $length number of characters
     */
    public function __construct($length = 1)
    {
        parent::__construct($length);
    }

    public function getType()
    {
        return self::TYPE_CHAR;
    }
}
