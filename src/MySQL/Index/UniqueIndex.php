<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Index;

class UniqueIndex extends AbstractIndex
{
    public function getType()
    {
        return self::INDEX_UNIQUE;
    }

    public function __toString()
    {
        return $this->makeIndexDDL($this->getType() . ' INDEX', $this->getName());
    }
}
