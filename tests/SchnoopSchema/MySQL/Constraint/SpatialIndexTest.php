<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexedColumnInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexInterface;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\IndexTestCase;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\ConstraintInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\SpatialIndex;

class SpatialIndexTest extends IndexTestCase
{
    protected $constraintName = 'schnoop_idx';

    /**
     * @var SpatialIndex
     */
    protected $spatialIndex;

    protected $indexedColumns = [];

    public function setUp()
    {
        parent::setUp();

        $this->spatialIndex = new SpatialIndex($this->constraintName);
    }

    public function testDDL()
    {
        $this->indexDDLAsserts("SPATIAL INDEX `{$this->constraintName}`");
    }

    protected function getConstraintName()
    {
        return $this->constraintName;
    }

    protected function getConstraintType()
    {
        return IndexInterface::CONSTRAINT_SPATIAL_INDEX;
    }

    protected function getIndexType()
    {
        return IndexInterface::INDEX_TYPE_RTREE;
    }

    /**
     * @return IndexInterface
     */
    protected function getIndex()
    {
        return $this->spatialIndex;
    }
}
