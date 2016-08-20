<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 20/06/16
 * Time: 8:58 PM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class TextType extends AbstractTextType
{
    const LENGTH = 65535;

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_TEXT;
    }
}
