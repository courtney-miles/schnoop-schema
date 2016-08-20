<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class VarBinaryType extends AbstractBinaryType
{
    const MAX_LENGTH = 65535;

    /**
     * VarBinaryType constructor.
     * @param int $length
     */
    public function __construct($length)
    {
        $this->setLength($length);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_VARBINARY;
    }
}
