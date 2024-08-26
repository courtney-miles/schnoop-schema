<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class VarBinaryType extends AbstractBinaryType
{
    public const MAX_LENGTH = 65535;

    public function __construct($length)
    {
        $this->setLength($length);
    }

    public function getType()
    {
        return self::TYPE_VARBINARY;
    }
}
