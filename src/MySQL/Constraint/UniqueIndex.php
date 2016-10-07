<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

class UniqueIndex extends AbstractIndex
{
    /**
     * UniqueIndex constructor.
     * @param string $name Index name.
     */
    public function __construct($name)
    {
        parent::__construct($name, self::CONSTRAINT_INDEX_UNIQUE, self::INDEX_TYPE_BTREE);
    }

    /**
     * {@inheritdoc}
     */
    public function setIndexType($indexType)
    {
        parent::setIndexType($indexType);
    }

    /**
     * {@inheritdoc}
     */
    public function getDDL()
    {
        if (strcasecmp('primary', $this->getName()) == 0) {
            return $this->makeIndexDDL('PRIMARY KEY', null);
        }

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
