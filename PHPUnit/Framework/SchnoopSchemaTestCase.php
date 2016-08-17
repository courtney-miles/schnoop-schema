<?php

namespace MilesAsylum\SchnoopSchema\PHPUnit\Framework;

use MilesAsylum\SchnoopSchema\MySQL\Column\ColumnInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\ConstraintInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\BinaryTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\IntTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\NumericPointTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\StringTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\TimeTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexedColumnInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexInterface;
use PHPUnit\Framework\TestCase;

class SchnoopSchemaTestCase extends TestCase
{
    /**
     * @param string $expectedType
     * @param int $expectedDisplayWidth
     * @param bool $expectedSigned
     * @param int $expectedMinRange
     * @param int $expectedMaxRange
     * @param bool $expectedAllowDefault
     * @param string $expectedDDL
     * @param IntTypeInterface $actualIntType
     */
    public function intTypeAsserts(
        $expectedType,
        $expectedDisplayWidth,
        $expectedSigned,
        $expectedMinRange,
        $expectedMaxRange,
        $expectedAllowDefault,
        $expectedDDL,
        IntTypeInterface $actualIntType
    ) {
        $this->assertSame($expectedType, $actualIntType->getType());
        $this->assertSame($expectedDisplayWidth, $actualIntType->getDisplayWidth());
        $this->assertSame($expectedSigned, $actualIntType->isSigned());
        $this->assertSame($expectedMinRange, $actualIntType->getMinRange());
        $this->assertSame($expectedMaxRange, $actualIntType->getMaxRange());
        $this->assertSame($expectedAllowDefault, $actualIntType->doesAllowDefault());
        $this->assertSame($expectedDDL, (string)$actualIntType);
    }

    /**
     * @param string $expectedType
     * @param bool $expectedSigned
     * @param int|null $expectedPrecision
     * @param int|null $expectedScale
     * @param string|null $expectedMinRange
     * @param string|null $expectedMaxRange
     * @param bool $expectedAllowDefault
     * @param string $expectedDDL
     * @param NumericPointTypeInterface $actualNumericPointType
     */
    public function numericPointTypeAsserts(
        $expectedType,
        $expectedSigned,
        $expectedPrecision,
        $expectedScale,
        $expectedMinRange,
        $expectedMaxRange,
        $expectedAllowDefault,
        $expectedDDL,
        NumericPointTypeInterface $actualNumericPointType
    ) {
        $this->assertSame(
            $expectedType,
            $actualNumericPointType->getType(),
            'Unexpected value returned for getType().'
        );
        $this->assertSame(
            $expectedPrecision,
            $actualNumericPointType->getPrecision(),
            'Unexpected value returned for getPrecision().'
        );
        $this->assertSame(
            $expectedScale,
            $actualNumericPointType->getScale(),
            'Unexpected value returned for getScale().'
        );
        $this->assertSame(
            $expectedSigned,
            $actualNumericPointType->isSigned(),
            'Unexpected value returned for isSigned().'
        );
        $this->assertSame(
            $expectedMinRange,
            $actualNumericPointType->getMinRange(),
            'Unexpected value returned for getMinRange().'
        );
        $this->assertSame(
            $expectedMaxRange,
            $actualNumericPointType->getMaxRange(),
            'Unexpected value returned for getMaxRange().'
        );
        $this->assertSame(
            $expectedAllowDefault,
            $actualNumericPointType->doesAllowDefault(),
            'Unexpected value returned for doesAllowDefault().'
        );
        $this->assertSame(
            $expectedDDL,
            (string)$actualNumericPointType,
            'Unexpected DDL value.'
        );
    }

    /**
     * @param string $expectedType
     * @param int $expectedLength
     * @param string|null $expectedCollation
     * @param bool $expectedAllowDefault
     * @param string $expectedDDL
     * @param StringTypeInterface $actualStringType
     */
    public function stringTypeAsserts(
        $expectedType,
        $expectedLength,
        $expectedCollation,
        $expectedAllowDefault,
        $expectedDDL,
        StringTypeInterface $actualStringType
    ) {
        $this->assertSame($expectedType, $actualStringType->getType());
        $this->assertSame($expectedLength, $actualStringType->getLength());
        $this->assertSame($expectedCollation, $actualStringType->getCollation());
        $this->assertSame($expectedAllowDefault, $actualStringType->doesAllowDefault());
        $this->assertSame($expectedDDL, (string)$actualStringType);
    }

    /**
     * @param string $expectedType
     * @param int $expectedLength
     * @param bool $expectedAllowDefault
     * @param string $expectedDDL
     * @param BinaryTypeInterface $actualStringType
     */
    public function binaryTypeAsserts(
        $expectedType,
        $expectedLength,
        $expectedAllowDefault,
        $expectedDDL,
        BinaryTypeInterface $actualStringType
    ) {
        $this->assertSame($expectedType, $actualStringType->getType());
        $this->assertSame($expectedLength, $actualStringType->getLength());
        $this->assertSame($expectedAllowDefault, $actualStringType->doesAllowDefault());
        $this->assertSame($expectedDDL, (string)$actualStringType);
    }

    /**
     * @param string $expectedType
     * @param int $expectedPrecision
     * @param true $expectedAllowDefault
     * @param string $expectedDDL
     * @param TimeTypeInterface $actualTimeType
     */
    public function timeTypeAsserts(
        $expectedType,
        $expectedPrecision,
        $expectedAllowDefault,
        $expectedDDL,
        TimeTypeInterface $actualTimeType
    ) {
        $this->assertSame($expectedType, $actualTimeType->getType());
        $this->assertSame($expectedPrecision, $actualTimeType->getPrecision());
        $this->assertSame($expectedAllowDefault, $actualTimeType->doesAllowDefault());
        $this->assertSame($expectedDDL, (string)$actualTimeType);
    }

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
