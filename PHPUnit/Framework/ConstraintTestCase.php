<?php

namespace MilesAsylum\SchnoopSchema\PHPUnit\Framework;

use MilesAsylum\SchnoopSchema\MySQL\Constraint\ConstraintInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexedColumn;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexInterface;
use MilesAsylum\SchnoopSchema\MySQL\Table\TableInterface;

abstract class ConstraintTestCase extends SchnoopSchemaTestCase
{
    /**
     * @return ConstraintInterface
     */
    abstract protected function getConstraint();

    abstract protected function getConstraintName();

    abstract protected function getConstraintType();

    public function testInitialProperties()
    {
        $constraint = $this->getConstraint();

        $this->assertSame($this->getConstraintName(), $constraint->getName(), 'Assertion on ' . get_class($constraint));
        $this->assertSame(
            $this->getConstraintType(),
            $constraint->getConstraintType(),
            'Assertion on ' . get_class($constraint)
        );

        $this->assertFalse($constraint->hasTable(), 'Assertion on ' . get_class($constraint));
        $this->assertNull($constraint->getTable(), 'Assertion on ' . get_class($constraint));
    }

    public function testSetTable()
    {
        $mockTable = $this->createMock(TableInterface::class);
        $constraint = $this->getConstraint();
        $constraint->setTable($mockTable);

        $this->assertTrue($constraint->hasTable(), 'Assertion on ' . get_class($constraint));
        $this->assertSame($mockTable, $constraint->getTable(), 'Assertion on ' . get_class($constraint));
    }
}
