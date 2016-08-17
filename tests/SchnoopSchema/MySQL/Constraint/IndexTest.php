<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexedColumnInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexInterface;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\IndexTestCase;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\Index;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\ConstraintInterface;

class IndexTest extends IndexTestCase
{
    /**
     * @var Index
     */
    protected $index;

    protected $constraintName = 'schnoop_idx';

    protected $indexedColumns = [];

    public function setUp()
    {
        parent::setUp();

        $this->index = new Index($this->constraintName);
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
