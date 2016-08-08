<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Index;

class Index extends AbstractIndex
{
    public function getType()
    {
        return self::INDEX_INDEX;
    }

    public function __toString()
    {
        if (strcasecmp('primary', $this->getName()) == 0) {
            return $this->makeIndexDDL('PRIMARY KEY');
        }

        return $this->makeIndexDDL($this->getType(), $this->getName(), $this->getIndexType());
    }
}
