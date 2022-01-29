<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\SpatialIndex;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\IndexTestCase;

class SpatialIndexTest extends IndexTestCase
{
    protected $constraintName = 'schnoop_idx';

    /**
     * @var SpatialIndex
     */
    protected $spatialIndex;

    protected $indexedColumns = [];

    public function setUp(): void
    {
        parent::setUp();

        $this->spatialIndex = new SpatialIndex($this->constraintName);
    }

    public function testDDL(): void
    {
        $this->indexDDLAsserts("SPATIAL INDEX `{$this->constraintName}`");
    }

    protected function getConstraintName()
    {
        return $this->constraintName;
    }

    protected function getConstraintType()
    {
        return IndexInterface::CONSTRAINT_INDEX_SPATIAL;
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
