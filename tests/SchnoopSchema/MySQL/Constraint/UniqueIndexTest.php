<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexInterface;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\IndexTestCase;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\UniqueIndex;

class UniqueIndexTest extends IndexTestCase
{
    protected $constraintName = 'schnoop_idx';

    /**
     * @var UniqueIndex
     */
    protected $uniqueIndex;

    protected $indexedColumns = [];

    public function setUp()
    {
        parent::setUp();

        $this->uniqueIndex = new UniqueIndex($this->constraintName);
    }

    public function testDDL()
    {
        $this->indexDDLAsserts("UNIQUE INDEX `{$this->constraintName}`");
    }

    public function testPublicKeyDDL()
    {
        $this->uniqueIndex = new UniqueIndex('primary');

        $this->indexDDLAsserts("PRIMARY KEY");
    }

    protected function getConstraintName()
    {
        return $this->constraintName;
    }

    protected function getConstraintType()
    {
        return IndexInterface::CONSTRAINT_UNIQUE_INDEX;
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
        return $this->uniqueIndex;
    }
}
