<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Column;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\Column\Column;
use MilesAsylum\SchnoopSchema\MySQL\Column\ColumnInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\NumericTypeInterface;
use PHPUnit_Framework_MockObject_MockObject;

class ColumnTest extends SchnoopSchemaTestCase
{
    /**
     * @dataProvider constructedColumnTestProvider
     * @param string $name
     * @param DataTypeInterface $dataType
     * @param bool $allowNull
     * @param mixed|null $default
     * @param string $comment
     * @param null|bool $zeroFill
     * @param null|bool $autoIncrement
     * @param bool $expectedHasDefault
     * @param string $expectedDDL
     */
    public function testConstructed(
        $name,
        DataTypeInterface $dataType,
        $allowNull,
        $default,
        $comment,
        $zeroFill,
        $autoIncrement,
        $expectedHasDefault,
        $expectedDDL
    ) {
        $column = new Column(
            $name,
            $dataType,
            $allowNull,
            $default,
            $comment,
            $zeroFill,
            $autoIncrement
        );

        $this->columnAsserts(
            $name,
            $dataType,
            $allowNull,
            $expectedHasDefault,
            $default,
            $comment,
            $zeroFill,
            $autoIncrement,
            $expectedDDL,
            $column
        );
    }

    public function testCastDefault()
    {
        $default = 'foo';
        $castDefault = 'FOO';

        $mockDataType = $this->createMock(DataTypeInterface::class);
        $mockDataType->method('doesAllowDefault')->willReturn(true);
        $mockDataType->expects($this->once())
            ->method('cast')
            ->with($default)
            ->willReturn($castDefault);

        $column = new Column(
            'schnoop_col',
            $mockDataType,
            false,
            $default,
            ''
        );

        $this->assertSame($castDefault, $column->getDefault());
    }

    public function testDDLWithArrayDefault()
    {
        $default = [
            'foo'
        ];
        $mockDataType = $this->createMock(DataTypeInterface::class);
        $mockDataType->method('__toString')->willReturn('FOO');
        $mockDataType->method('doesAllowDefault')->willReturn(true);
        $mockDataType->method('cast')->willReturn($default);
        $mockDataType->expects($this->once())
            ->method('quote')
            ->with($default[0])
            ->willReturn("'{$default[0]}'");

        $column = new Column(
            'schnoop_col',
            $mockDataType,
            false,
            $default,
            ''
        );

        $this->assertSame("`schnoop_col` FOO NOT NULL DEFAULT ('foo')", (string)$column);
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
            'foo',
            $mockDataType,
            false,
            'Foo',
            ''
        );
    }

    public function testNoDefaultWhenDefaultNotAllowed()
    {
        /** @var DataTypeInterface|PHPUnit_Framework_MockObject_MockObject $mockDataType */
        $mockDataType = $this->createMock(DataTypeInterface::class);
        $mockDataType->method('cast')
            ->willReturn('');
        $mockDataType->method('doesAllowDefault')
            ->willReturn(false);

        $column = @new Column(
            'foo',
            $mockDataType,
            false,
            'Foo',
            ''
        );

        $this->assertFalse($column->hasDefault());
        $this->assertNull($column->getDefault());
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

        $doAllowNull = true;
        $expectHasDefault = true;
        $doZeroFill = true;
        $doAutoIncrement = true;

        // Test 'baseline' (NOT NULL, No Default, Irrelevant ZEROFILL, Irrelevant AUTOINCREMENT)
        $mockDataType = $this->newMockDataType(DataTypeInterface::class, null, true);
        $returnParams[] = [
            $name,
            $mockDataType,
            !$doAllowNull,
            $nullDefault,
            $comment,
            null,
            null,
            !$expectHasDefault,
            "`$name` FOO NOT NULL COMMENT '$comment'"
        ];

        // Test 'baseline' + Allow NULL
        $mockDataType = $this->newMockDataType(DataTypeInterface::class, null, true);
        $returnParams[] = [
            $name,
            $mockDataType,
            $doAllowNull, // <-- This is significant to this test.
            $nullDefault,
            $comment,
            null,
            null,
            $expectHasDefault, // <-- This is significant to this test. If columns allows null, then the column will have a default of NULL.
            "`$name` FOO NULL DEFAULT NULL COMMENT '$comment'"
        ];

        // Test 'baseline' + Default
        $default = 123;
        $mockDataType = $this->newMockDataType(DataTypeInterface::class, $default, true);

        $returnParams[] = [
            $name,
            $mockDataType,
            !$doAllowNull,
            $default,
            $comment,
            null,
            null,
            $expectHasDefault, // <-- This is significant to this test.
            "`$name` FOO NOT NULL DEFAULT '$default' COMMENT '$comment'"
        ];

        // Test 'baseline' + Allow NULL + Not Allow Default
        $mockDataType = $this->newMockDataType(
            DataTypeInterface::class,
            null,
            false // <-- This is significant to this test.
        );
        $returnParams[] = [
            $name,
            $mockDataType,
            $doAllowNull, // <-- This is significant to this test.
            $nullDefault,
            $comment,
            null,
            null,
            !$expectHasDefault, // <-- This is significant to this test.
            "`$name` FOO NULL COMMENT '$comment'"
        ];

        // Test 'baseline' + NumericDataType + Not Zero Fill + Not AutoIncrement
        $mockDataType = $this->newMockDataType(NumericTypeInterface::class, null, true);
        $returnParams[] = [
            $name,
            $mockDataType,
            !$doAllowNull,
            null,
            $comment,
            !$doZeroFill, // <-- This is significant to this test.
            !$doAutoIncrement, // <-- This is significant to this test.
            !$expectHasDefault,
            "`$name` FOO NOT NULL COMMENT '$comment'"
        ];

        // Test 'baseline' + NumericDataType + Zero Fill + Not AutoIncrement
        $mockDataType = $this->newMockDataType(NumericTypeInterface::class, null, true);
        $returnParams[] = [
            $name,
            $mockDataType,
            !$doAllowNull,
            null,
            $comment,
            $doZeroFill, // <-- This is significant to this test.
            !$doAutoIncrement, // <-- This is significant to this test.
            !$expectHasDefault,
            "`$name` FOO ZEROFILL NOT NULL COMMENT '$comment'"
        ];

        // Test 'baseline' + NumericDataType + Not Zero Fill + AutoIncrement
        $mockDataType = $this->newMockDataType(NumericTypeInterface::class, null, true);
        $returnParams[] = [
            $name,
            $mockDataType,
            !$doAllowNull,
            null,
            $comment,
            !$doZeroFill, // <-- This is significant to this test.
            $doAutoIncrement, // <-- This is significant to this test.
            !$expectHasDefault,
            "`$name` FOO NOT NULL AUTO_INCREMENT COMMENT '$comment'"
        ];

        return $returnParams;
    }

    /**
     * @param $interfaceName
     * @param $default
     * @param $doesAllowDefault
     * @return NumericTypeInterface|PHPUnit_Framework_MockObject_MockObject
     */
    protected function newMockDataType($interfaceName, $default, $doesAllowDefault)
    {
        $mockDataType = $this->createMock($interfaceName);
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
