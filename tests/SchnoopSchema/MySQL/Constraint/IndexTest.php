<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexInterface;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\IndexTestCase;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\Index;

class IndexTest extends IndexTestCase
{
    /**
     * @var Index
     */
    protected $index;

    protected $constraintName = 'schnoop_idx';

    protected $indexedColumns = [];

    public function setUp(): void
    {
        parent::setUp();

        $this->index = new Index($this->constraintName);
    }

    public function testDDL()
    {
        $this->indexDDLAsserts("INDEX `{$this->constraintName}`");
    }

    protected function getConstraintName()
    {
        return $this->constraintName;
    }

    protected function getConstraintType()
    {
        return IndexInterface::CONSTRAINT_INDEX;
    }

    protected function getIndexType()
    {
        return IndexInterface::INDEX_TYPE_BTREE;
    }

    /**
     * @return IndexInterface
     */
    protected function getIndex()
    {
        return $this->index;
    }
}
