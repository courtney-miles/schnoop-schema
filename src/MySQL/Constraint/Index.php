<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

class Index extends AbstractIndex
{
    public function __construct($name)
    {
        parent::__construct($name, self::CONSTRAINT_INDEX, self::INDEX_TYPE_BTREE);
    }

    public function __toString()
    {
        return $this->makeIndexDDL($this->getConstraintType(), $this->getName(), $this->getIndexType());
    }
}
