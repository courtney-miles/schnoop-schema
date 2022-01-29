<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class BlobType extends AbstractBlobType
{
    public const LENGTH = 65535;

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE_BLOB;
    }
}
