<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class VarCharType extends AbstractCharType
{
    public const MAX_LENGTH = 65535;

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE_VARCHAR;
    }
}
