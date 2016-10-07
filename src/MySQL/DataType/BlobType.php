<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class BlobType extends AbstractBlobType
{
    const LENGTH = 65535;

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE_BLOB;
    }
}
