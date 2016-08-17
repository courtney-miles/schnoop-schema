<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

class FullTextIndex extends AbstractIndex
{
    public function __construct($name)
    {
        parent::__construct($name, self::CONSTRAINT_FULLTEXT, self::INDEX_TYPE_FULLTEXT);
    }

    public function __toString()
    {
        return $this->makeIndexDDL($this->getConstraintType(), $this->getName());
    }
}
