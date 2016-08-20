<?php

namespace MilesAsylum\SchnoopSchema\PHPUnit\Framework;

use MilesAsylum\SchnoopSchema\MySQL\Column\ColumnInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\ConstraintInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\BinaryTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\IntTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\NumericPointTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\CharTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\TimeTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexedColumnInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexInterface;
use PHPUnit\Framework\TestCase;

class SchnoopSchemaTestCase extends TestCase
{
    /**
     * @param $constraintName
     * @param $constraintDDL
     * @return ConstraintInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function createMockConstraint($constraintName, $constraintDDL)
    {
        $mockConstraint = $this->createMock(ConstraintInterface::class);
        $mockConstraint->method('getName')
            ->willReturn($constraintName);
        $mockConstraint->method('__toString')
            ->willReturn($constraintDDL);

        return $mockConstraint;
    }
}
