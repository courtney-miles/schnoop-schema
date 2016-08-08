<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class LongTextType extends AbstractTextType
{
    const LENGTH = 4294967295;

    public function __construct($collation = null)
    {
        parent::__construct(self::LENGTH, $collation);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_LONGTEXT;
    }
}
