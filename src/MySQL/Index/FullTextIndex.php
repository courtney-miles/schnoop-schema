<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Index;

class FullTextIndex extends AbstractIndex
{
    public function __construct($name, array $indexedColumns, $comment)
    {
        parent::__construct($name, $indexedColumns, self::INDEX_TYPE_FULLTEXT, $comment);
    }

    public function getType()
    {
        return self::INDEX_FULLTEXT;
    }

    public function __toString()
    {
        return $this->makeIndexDDL($this->getType(), $this->getName());
    }
}
