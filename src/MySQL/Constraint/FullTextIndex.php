<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

class FullTextIndex extends AbstractIndex
{
    /**
     * FullTextIndex constructor.
     * @param string $name Index name.
     */
    public function __construct($name)
    {
        parent::__construct($name, self::CONSTRAINT_INDEX_FULLTEXT, self::INDEX_TYPE_FULLTEXT);
    }

    /**
     * {@inheritdoc}
     */
    public function getDDL()
    {
        return $this->makeIndexDDL($this->getConstraintType(), $this->getName());
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getDDL();
    }
}
