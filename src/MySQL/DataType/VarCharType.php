<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class VarCharType extends AbstractCharType
{
    const MAX_LENGTH = 65535;

    public function __construct($length)
    {
        $this->setLength($length);
    }

    public function getType()
    {
        return self::TYPE_VARCHAR;
    }
}
