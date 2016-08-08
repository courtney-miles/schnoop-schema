<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 23/06/16
 * Time: 7:16 AM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class MediumTextType extends AbstractTextType
{
    const LENGTH = 16777215;

    public function __construct($collation = null)
    {
        parent::__construct(self::LENGTH, $collation);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_MEDIUMTEXT;
    }
}