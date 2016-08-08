<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 18/06/16
 * Time: 6:16 PM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

trait SignedTrait
{
    /**
     * @var bool
     */
    protected $signed;

    /**
     * @return boolean
     */
    public function isSigned()
    {
        return $this->signed;
    }

    /**
     * @param boolean $signed
     */
    protected function setSigned($signed)
    {
        $this->signed = (bool)$signed;
    }
}