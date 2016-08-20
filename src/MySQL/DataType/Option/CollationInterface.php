<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 8/07/16
 * Time: 7:23 AM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

interface CollationInterface
{
    /**
     * @return string
     */
    public function getCollation();

    public function hasCollation();

    public function setCollation($collation);
}
