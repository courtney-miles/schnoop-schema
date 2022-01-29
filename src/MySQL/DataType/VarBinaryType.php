<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class VarBinaryType extends AbstractBinaryType
{
    public const MAX_LENGTH = 65535;

    /**
     * {@inheritdoc}
     */
    public function __construct($length)
    {
        $this->setLength($length);
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE_VARBINARY;
    }
}
