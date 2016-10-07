<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

trait SignedTrait
{
    /**
     * @var bool
     */
    protected $signed;

    /**
     * @see SignedInterface::isSigned()
     */
    public function isSigned()
    {
        return $this->signed;
    }

    /**
     * @see SignedInterface::setSigned()
     */
    public function setSigned($signed)
    {
        $this->signed = (bool)$signed;
    }
}
