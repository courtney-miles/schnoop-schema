<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 8/07/16
 * Time: 7:26 AM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

trait CollationTrait
{
    /**
     * Collation.
     * @var string
     */
    protected $collation;

    /**
     * @see CollationInterface::getCollation()
     */
    public function getCollation()
    {
        return $this->collation;
    }

    /**
     * @see CollationInterface::hasCollation()
     */
    public function hasCollation()
    {
        return !empty($this->collation);
    }

    /**
     * @see CollationInterface::setCollation()
     */
    public function setCollation($collation)
    {
        $this->collation = $collation;
    }
}
