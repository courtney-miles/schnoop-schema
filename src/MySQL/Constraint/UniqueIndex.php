<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

class UniqueIndex extends AbstractIndex
{
    /**
     * UniqueIndex constructor.
     *
     * @param string $name index name
     */
    public function __construct($name)
    {
        parent::__construct($name, self::CONSTRAINT_INDEX_UNIQUE, self::INDEX_TYPE_BTREE);
    }

    /**
     * {@inheritdoc}
     */
    public function setIndexType($indexType): void
    {
        parent::setIndexType($indexType);
    }

    /**
     * {@inheritdoc}
     */
    public function getDDL()
    {
        if (0 == strcasecmp('primary', $this->getName())) {
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
