<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexedColumnInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexInterface;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\IndexTestCase;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\ConstraintInterface;
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

    protected function getConstraintName()
    {
        return $this->constraintName;
    }

    protected function getConstraintType()
    {
        return IndexInterface::CONSTRAINT_UNIQUE;
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
