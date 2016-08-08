<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Column;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopTestCase;
use MilesAsylum\SchnoopSchema\MySQL\Column\Column;
use MilesAsylum\SchnoopSchema\MySQL\Column\ColumnInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\NumericTypeInterface;
use PHPUnit_Framework_MockObject_MockObject;

class ColumnTest extends SchnoopTestCase
{
    /**
     * @var Column
     */
    protected $column;

    protected $name = 'schnoop_col';

    /**
     * @var DataTypeInterface|PHPUnit_Framework_MockObject_MockObject
     */
    protected $mockDataType;

    protected $allowNull = true;
    
    protected $default = '123';

    protected $comment = 'Schnoop column.';

    public function setUp()
    {
        parent::setUp();

        $this->mockDataType = $this->createMock(DataTypeInterface::class);
        $this->mockDataType->method('cast')
            ->willReturn((int)$this->default);
        $this->mockDataType->method('doesAllowDefault')
            ->willReturn(true);

        $this->column = new Column(
            $this->name,
            $this->mockDataType,
            $this->allowNull,
            $this->default,
            $this->comment
        );
    }

    /**
     * @dataProvider constructedColumnTestProvider
     * @param $expectedName
     * @param DataTypeInterface $expectedDataType
     * @param $expectedAllowNull
     * @param $expectedHasDefault
     * @param $expectedDefault
     * @param $expectedComment
     * @param $expectedZeroFill
     * @param $expectedAutoIncrement
     * @param $expectedDDL
     * @param ColumnInterface $column
     */
    public function testConstructed(
        $expectedName,
        DataTypeInterface $expectedDataType,
        $expectedAllowNull,
        $expectedHasDefault,
        $expectedDefault,
        $expectedComment,
        $expectedZeroFill,
        $expectedAutoIncrement,
        $expectedDDL,
        ColumnInterface $column
    ) {
        $this->columnAsserts(
            $expectedName,
            $expectedDataType,
            $expectedAllowNull,
            $expectedHasDefault,
            $expectedDefault,
            $expectedComment,
            $expectedZeroFill,
            $expectedAutoIncrement,
            $expectedDDL,
            $column
        );
    }

    /**
     * @expectedException \PHPUnit_Framework_Error_Warning
     * @expectedExceptionMessage Attempt made to set a default value for a data-type that does not support a default. The supplied default value has been ignored.
     */
    public function testWarningWhenSetDefaultWhenNotAllowed()
    {
        /** @var DataTypeInterface|PHPUnit_Framework_MockObject_MockObject $mockDataType */
        $mockDataType = $this->createMock(DataTypeInterface::class);
        $mockDataType->method('cast')
            ->willReturn('');
        $mockDataType->method('doesAllowDefault')
            ->willReturn(false);

        $column = new Column(
            $this->name,
            $mockDataType,
            false,
            'Foo',
            $this->comment
        );
    }

    /**
     * @see testConstructed
     * @return array
     */
    public function constructedColumnTestProvider()
    {
        $returnParams = [];

        $name = 'schnoop_column';
        $comment = 'schnoop_comment';
        $nullDefault = null;
        $castNullDefault = null;

        // Test 'baseline' (NOT NULL, No Default, Irrelevant ZEROFILL, Irrelevant AUTOINCREMENT)
        $mockDataType = $this->newMockDataType('DataTypeInterface', null, true);
        $returnParams[] = $this->constructedColumnTestParamArray(
            $name,
            $mockDataType,
            false,
            false,
            null,
            $comment,
            null,
            null,
            "`$name` FOO NOT NULL COMMENT '$comment'",
            new Column(
                $name,
                $mockDataType,
                false,
                null,
                $comment
            )
        );

        // Test 'baseline' + Allow NULL
        $mockDataType = $this->newMockDataType('DataTypeInterface', null, true);
        $returnParams[] = $this->constructedColumnTestParamArray(
            $name,
            $mockDataType,
            true, // <-- This is significant to this test.
            true, // <-- This is significant to this test. If columns allows null, then the column will have a default of NULL.
            null,
            $comment,
            null,
            null,
            "`$name` FOO NULL DEFAULT NULL COMMENT '$comment'",
            new Column(
                $name,
                $mockDataType,
                true, // <-- This is significant to this test.
                null, // <-- This is significant to this test.
                $comment
            )
        );

        // Test 'baseline' + Default
        $default = 123;
        $castDefault = 'abc'; // Not the same as $default to ensure the supplied value is cast.
        $mockDataType = $this->newMockDataType('DataTypeInterface', $castDefault, true);
        $returnParams[] = $this->constructedColumnTestParamArray(
            $name,
            $mockDataType,
            false,
            true, // <-- This is significant to this test.
            $castDefault,
            $comment,
            null,
            null,
            "`$name` FOO NOT NULL DEFAULT 'abc' COMMENT '$comment'",
            new Column(
                $name,
                $mockDataType,
                false,
                $default, // <-- This is significant to this test.
                $comment
            )
        );

        // Test 'baseline' + Allow NULL + Not Allow Default
        $mockDataType = $this->newMockDataType(
            'DataTypeInterface',
            null,
            false // <-- This is significant to this test.
        );
        $returnParams[] = $this->constructedColumnTestParamArray(
            $name,
            $mockDataType,
            true, // <-- This is significant to this test.
            false, // <-- This is significant to this test.
            null,
            $comment,
            null,
            null,
            "`$name` FOO NULL COMMENT '$comment'",
            new Column(
                $name,
                $mockDataType,
                true, // <-- This is significant to this test.
                null,
                $comment
            )
        );

        // Test 'baseline' + NumericDataType + Not Zero Fill + Not AutoIncrement
        $mockDataType = $this->newMockDataType('NumericTypeInterface', null, true);
        $returnParams[] = $this->constructedColumnTestParamArray(
            $name,
            $mockDataType,
            false,
            false,
            null,
            $comment,
            false, // <-- This is significant to this test.
            false, // <-- This is significant to this test.
            "`$name` FOO NOT NULL COMMENT '$comment'",
            new Column(
                $name,
                $mockDataType,
                false,
                null,
                $comment
            )
        );

        // Test 'baseline' + NumericDataType + Zero Fill + Not AutoIncrement
        $mockDataType = $this->newMockDataType('NumericTypeInterface', null, true);
        $returnParams[] = $this->constructedColumnTestParamArray(
            $name,
            $mockDataType,
            false,
            false,
            null,
            $comment,
            true, // <-- This is significant to this test.
            false, // <-- This is significant to this test.
            "`$name` FOO ZEROFILL NOT NULL COMMENT '$comment'",
            new Column(
                $name,
                $mockDataType,
                false,
                null,
                $comment,
                true // <-- This is significant to this test.
            )
        );

        // Test 'baseline' + NumericDataType + Not Zero Fill + AutoIncrement
        $mockDataType = $this->newMockDataType('NumericTypeInterface', null, true);
        $returnParams[] = $this->constructedColumnTestParamArray(
            $name,
            $mockDataType,
            false,
            false,
            null,
            $comment,
            false, // <-- This is significant to this test.
            true, // <-- This is significant to this test.
            "`$name` FOO NOT NULL AUTO_INCREMENT COMMENT '$comment'",
            new Column(
                $name,
                $mockDataType,
                false,
                null,
                $comment,
                false, // <-- This is significant to this test.
                true // <-- This is significant to this test.
            )
        );

        return $returnParams;
    }

    /**
     * @param $expectedName
     * @param DataTypeInterface $expectedDataType
     * @param $expectedAllowNull
     * @param $expectedHasDefault
     * @param $expectedDefault
     * @param $expectedComment
     * @param $expectedZeroFill
     * @param $expectedAutoIncrement
     * @param $expectedDDL
     * @param ColumnInterface $column
     * @return array
     */
    protected function constructedColumnTestParamArray(
        $expectedName,
        DataTypeInterface $expectedDataType,
        $expectedAllowNull,
        $expectedHasDefault,
        $expectedDefault,
        $expectedComment,
        $expectedZeroFill,
        $expectedAutoIncrement,
        $expectedDDL,
        ColumnInterface $column
    ) {
        return [
            $expectedName,
            $expectedDataType,
            $expectedAllowNull,
            $expectedHasDefault,
            $expectedDefault,
            $expectedComment,
            $expectedZeroFill,
            $expectedAutoIncrement,
            $expectedDDL,
            $column
        ];
    }

    /**
     * @param $interfaceName
     * @param $default
     * @param $doesAllowDefault
     * @return NumericTypeInterface|PHPUnit_Framework_MockObject_MockObject
     */
    protected function newMockDataType($interfaceName, $default, $doesAllowDefault)
    {
        $mockDataType = $this->createMock('MilesAsylum\SchnoopSchema\MySQL\DataType\\'. $interfaceName);
        $mockDataType->method('__toString')
            ->willReturn('FOO');
        $mockDataType->method('cast')
            ->willReturn($default);
        $mockDataType->method('quote')
            ->willReturn("'" . addslashes($default) . "'");
        $mockDataType->method('doesAllowDefault')
            ->willReturn($doesAllowDefault);

        return $mockDataType;
    }
}
