<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\Constraint\AbstractIndex;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\ConstraintInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexInterface;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\IndexTestCase;

class AbstractIndexTest extends IndexTestCase
{
    /**
     * @var AbstractIndex
     */
    protected $abstractIndex;

    protected $constraintName = 'schnoop_idx';

    protected $constraintType = ConstraintInterface::CONSTRAINT_INDEX;

    protected $indexType = IndexInterface::INDEX_TYPE_BTREE;

    public function setUp(): void
    {
        $this->abstractIndex = $this->getMockForAbstractClass(
            AbstractIndex::class,
            [
                $this->constraintName,
                $this->constraintType,
                $this->indexType,
            ]
        );

        parent::setUp();
    }

    protected function getIndex()
    {
        return $this->abstractIndex;
    }

    protected function getConstraintName()
    {
        return $this->constraintName;
    }

    protected function getConstraintType()
    {
        return $this->constraintType;
    }

    protected function getIndexType()
    {
        return $this->indexType;
    }
}
