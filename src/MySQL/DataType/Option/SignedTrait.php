<?php

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
    public function setSigned($signed)
    {
        $this->signed = (bool)$signed;
    }
}
