<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\Constraint\AbstractConstraint;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\ConstraintInterface;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\ConstraintTestCase;

class AbstractConstraintTest extends ConstraintTestCase
{
    /**
     * @var AbstractConstraint
     */
    protected $abstractConstraint;

    protected $constraintName = 'schnoop_idx';

    protected $constraintType = ConstraintInterface::CONSTRAINT_INDEX;

    public function setUp(): void
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
