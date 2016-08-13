<?php

namespace MilesAsylum\SchnoopSchema\PHPUnit\Framework;

use MilesAsylum\SchnoopSchema\MySQL\Column\ColumnInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\BinaryTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\IntTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\NumericPointTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\StringTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\TimeTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\Index\IndexInterface;
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
     * @param string $expectedName
     * @param DataTypeInterface|string $expectedDataType
     * @param bool $expectedAllowNull
     * @param $expectedHasDefault
     * @param string $expectedDefault
     * @param string $expectedComment
     * @param $expectedZeroFill
     * @param $expectedAutoIncrement
     * @param string $expectedDDL
     * @param ColumnInterface $actualColumn
     */
    public function columnAsserts(
        $expectedName,
        $expectedDataType,
        $expectedAllowNull,
        $expectedHasDefault,
        $expectedDefault,
        $expectedComment,
        $expectedZeroFill,
        $expectedAutoIncrement,
        $expectedDDL,
        ColumnInterface $actualColumn
    ) {
        $this->assertSame($expectedName, $actualColumn->getName());
        $this->assertSame($expectedDataType, $actualColumn->getDataType());
        $this->assertSame($expectedAllowNull, $actualColumn->doesAllowNull());
        $this->assertSame($expectedHasDefault, $actualColumn->hasDefault());
        $this->assertSame($expectedDefault, $actualColumn->getDefault());
        $this->assertSame($expectedComment, $actualColumn->getComment());
        $this->assertSame($expectedZeroFill, $actualColumn->doesZeroFill());
        $this->assertSame($expectedAutoIncrement, $actualColumn->isAutoIncrement());
        $this->assertSame($expectedDDL, (string)$actualColumn);
    }

    /**
     * @param string $expectedName
     * @param string $expectedType
     * @param ColumnInterface[] $expectedIndexedColumns
     * @param string $expectedIndexType
     * @param string $expectedComment
     * @param bool $expectedHasComment
     * @param string $expectedDDL
     * @param IndexInterface $actualIndex
     */
    public function indexAsserts(
        $expectedName,
        $expectedType,
        array $expectedIndexedColumns,
        $expectedIndexType,
        $expectedComment,
        $expectedHasComment,
        $expectedDDL,
        IndexInterface $actualIndex
    ) {
        $this->assertSame(
            $expectedName,
            $actualIndex->getName(),
            'Index name is not what is expected.'
        );
        $this->assertSame(
            $expectedIndexedColumns,
            $actualIndex->getIndexedColumns(),
            'Indexed columns are not what is expected.'
        );
        $this->assertSame(
            $expectedIndexType,
            $actualIndex->getIndexType(),
            'Index type is not what is expected.'
        );
        $this->assertSame(
            $expectedComment,
            $actualIndex->getComment(),
            'Index comment is not what is expected.'
        );
        $this->assertSame(
            $expectedHasComment,
            $actualIndex->hasComment(),
            'Index having a comment is not what is expected.'
        );

        if ($expectedType !== null) {
            $this->assertSame(
                $expectedType,
                $actualIndex->getType(),
                'Index type is not what is expected.'
            );
        }

        if ($expectedDDL !== null) {
            $this->assertSame(
                $expectedDDL,
                (string)$actualIndex,
                'Index DDL is not what is expected.'
            );
        }
    }
}
