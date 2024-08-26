<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

class FullTextIndex extends AbstractIndex
{
    /**
     * FullTextIndex constructor.
     *
     * @param string $name index name
     */
    public function __construct($name)
    {
        parent::__construct($name, self::CONSTRAINT_INDEX_FULLTEXT, self::INDEX_TYPE_FULLTEXT);
    }

    public function getDDL()
    {
        return $this->makeIndexDDL($this->getConstraintType(), $this->getName());
    }

    public function __toString()
    {
        return $this->getDDL();
    }
}
