<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\Constraint\AbstractConstraint;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\ConstraintInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexedColumn;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexInterface;
use MilesAsylum\SchnoopSchema\MySQL\Table\TableInterface;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\ConstraintTestCase;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\AbstractIndex;

class AbstractConstraintTest extends ConstraintTestCase
{
    /**
     * @var AbstractConstraint
     */
    protected $abstractConstraint;

    protected $constraintName = 'schnoop_idx';

    protected $constraintType = ConstraintInterface::CONSTRAINT_INDEX;

    public function setUp()
    {
        parent::setUp();

        $this->abstractConstraint = $this->getMockForAbstractClass(
            AbstractConstraint::class,
            [
                $this->constraintName,
                $this->constraintType,
            ]
        );
    }

    protected function getConstraint()
    {
        return $this->abstractConstraint;
    }

    protected function getConstraintName()
    {
        return $this->constraintName;
    }

    protected function getConstraintType()
    {
        return $this->constraintType;
    }
}
