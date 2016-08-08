<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 1/07/16
 * Time: 7:11 AM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

abstract class AbstractBlobType extends AbstractBinaryType implements BlobTypeInterface
{
    public function doesAllowDefault()
    {
        return false;
    }

    public function __toString()
    {
        return strtoupper($this->getType());
    }
}
