<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

class SpatialIndex extends AbstractIndex
{
    /**
     * SpatialIndex constructor.
     * @param string $name Index name.
     */
    public function __construct($name)
    {
        parent::__construct($name, self::CONSTRAINT_INDEX_SPATIAL, self::INDEX_TYPE_RTREE);
    }

    /**
     * {@inheritdoc}
     */
    public function getConstraintType()
    {
        return self::CONSTRAINT_INDEX_SPATIAL;
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
