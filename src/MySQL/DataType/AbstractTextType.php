<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 1/07/16
 * Time: 7:10 AM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

abstract class AbstractTextType extends AbstractStringType implements TextTypeInterface
{
    public function doesAllowDefault()
    {
        return false;
    }

    public function __toString()
    {
        return implode(
            ' ',
            array_filter(
                [
                    strtoupper($this->getType()),
                    $this->hasCollation() ? "COLLATE '" . addslashes($this->getCollation()) . "'" : null
                ]
            )
        );
    }
}
