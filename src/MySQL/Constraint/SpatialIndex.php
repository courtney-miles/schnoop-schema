<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

class SpatialIndex extends AbstractIndex
{
    /**
     * SpatialIndex constructor.
     *
     * @param string $name index name
     */
    public function __construct($name)
    {
        parent::__construct($name, self::CONSTRAINT_INDEX_SPATIAL, self::INDEX_TYPE_RTREE);
    }

    public function getConstraintType()
    {
        return self::CONSTRAINT_INDEX_SPATIAL;
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
