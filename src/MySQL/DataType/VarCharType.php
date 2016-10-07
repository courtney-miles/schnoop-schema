<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class VarCharType extends AbstractCharType
{
    const MAX_LENGTH = 65535;

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE_VARCHAR;
    }
}
