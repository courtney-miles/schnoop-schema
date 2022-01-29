<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

class Index extends AbstractIndex
{
    /**
     * Index constructor.
     *
     * @param string $name index name
     */
    public function __construct($name)
    {
        parent::__construct($name, self::CONSTRAINT_INDEX, self::INDEX_TYPE_BTREE);
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
