<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\ColumnInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexedColumnInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexInterface;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\IndexTestCase;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\FullTextIndex;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\ConstraintInterface;

class FullTextIndexTest extends IndexTestCase
{
    protected $constraintName = 'schnoop_idx';

    protected $fullTextIndex;

    public function setUp()
    {
        $this->fullTextIndex = new FullTextIndex($this->constraintName);

        parent::setUp();
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
        return IndexInterface::CONSTRAINT_FULLTEXT;
    }

    protected function getIndexType()
    {
        return IndexInterface::INDEX_TYPE_FULLTEXT;
    }
}
