<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 23/06/16
 * Time: 7:33 AM.
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class MediumBlobType extends AbstractBlobType
{
    public const LENGTH = 16777215;

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE_MEDIUMBLOB;
    }
}
