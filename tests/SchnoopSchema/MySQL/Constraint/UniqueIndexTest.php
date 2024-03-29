<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\UniqueIndex;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\IndexTestCase;

class UniqueIndexTest extends IndexTestCase
{
    protected $constraintName = 'schnoop_idx';

    /**
     * @var UniqueIndex
     */
    protected $uniqueIndex;

    protected $indexedColumns = [];

    public function setUp(): void
    {
        parent::setUp();

        $this->uniqueIndex = new UniqueIndex($this->constraintName);
    }

    public function testDDL(): void
    {
        $this->indexDDLAsserts("UNIQUE INDEX `{$this->constraintName}`");
    }

    public function testPublicKeyDDL(): void
    {
        $this->uniqueIndex = new UniqueIndex('primary');

        $this->indexDDLAsserts('PRIMARY KEY');
    }

    protected function getConstraintName()
    {
        return $this->constraintName;
    }

    protected function getConstraintType()
    {
        return IndexInterface::CONSTRAINT_INDEX_UNIQUE;
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
