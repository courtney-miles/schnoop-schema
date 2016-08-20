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
     * @var string
     */
    protected $collation;

    /**
     * @return string
     */
    public function getCollation()
    {
        return $this->collation;
    }

    public function hasCollation()
    {
        return !empty($this->collation);
    }

    /**
     * @param string $collation
     * @internal param string $characterSet
     */
    public function setCollation($collation)
    {
        $this->collation = $collation;
    }
}
