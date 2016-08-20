<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType\Option;

interface SignedInterface
{
    public function isSigned();

    public function setSigned($signed);
}
