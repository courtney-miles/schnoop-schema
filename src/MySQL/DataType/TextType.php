<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 20/06/16
 * Time: 8:58 PM.
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class TextType extends AbstractTextType
{
    public const LENGTH = 65535;

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE_TEXT;
    }

    /**
     * {@inheritdoc}
     */
    public function getLength()
    {
        return self::LENGTH;
    }
}
