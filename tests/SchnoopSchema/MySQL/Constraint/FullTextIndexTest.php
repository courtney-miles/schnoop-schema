<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexInterface;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\IndexTestCase;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\FullTextIndex;

class FullTextIndexTest extends IndexTestCase
{
    protected $constraintName = 'schnoop_idx';

    protected $fullTextIndex;

    public function setUp(): void
    {
        $this->fullTextIndex = new FullTextIndex($this->constraintName);

        parent::setUp();
    }

    public function testDDL()
    {
        $this->indexDDLAsserts("FULLTEXT INDEX `{$this->constraintName}`");
    }

    /**
     * @return IndexInterface
     */
    protected function getIndex()
    {
        return $this->fullTextIndex;
    }

    protected function getConstraintName()
    {
        return $this->constraintName;
    }

    protected function getConstraintType()
    {
        return IndexInterface::CONSTRAINT_INDEX_FULLTEXT;
    }

    protected function getIndexType()
    {
        return IndexInterface::INDEX_TYPE_FULLTEXT;
    }
}
