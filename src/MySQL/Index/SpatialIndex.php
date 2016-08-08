<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Index;

class SpatialIndex extends AbstractIndex
{
    public function __construct($name, array $indexedColumns, $comment)
    {
        parent::__construct($name, $indexedColumns, self::INDEX_TYPE_RTREE, $comment);
    }

    public function getType()
    {
        return self::INDEX_SPATIAL;
    }

    public function __toString()
    {
        return $this->makeIndexDDL($this->getType(), $this->getName());
    }
}
