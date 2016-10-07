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
     * Get the collation for the type.
     * @return string Collation.
     */
    public function getCollation();

    /**
     * Identify if the collation is set for the type.
     * @return bool
     */
    public function hasCollation();

    /**
     * Set the collation for the type.
     * @param string $collation Collation.
     */
    public function setCollation($collation);
}
