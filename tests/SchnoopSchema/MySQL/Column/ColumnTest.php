<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Column;

use MilesAsylum\SchnoopSchema\Exception\ColumnException;
use MilesAsylum\SchnoopSchema\MySQL\DataType\SetType;
use MilesAsylum\SchnoopSchema\MySQL\Table\TableInterface;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\Column\Column;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\NumericTypeInterface;
use PHPUnit_Framework_MockObject_MockObject;

class ColumnTest extends SchnoopSchemaTestCase
{
    /**
     * @var Column
     */
    protected $column;

    protected $name = 'schnoop_col';

    /**
     * @var DataTypeInterface|PHPUnit_Framework_MockObject_MockObject
     */
    protected $dataType;

    public function setUp()
    {
        parent::setUp();

        $this->dataType = $this->createMock(DataTypeInterface::class);
        $this->dataType->method('doesAllowDefault')->willReturn(true);

        $this->column = new Column($this->name, $this->dataType);
    }

    public function testInitialProperties()
    {
        $this->assertSame($this->name, $this->column->getName());
        $this->assertSame($this->dataType, $this->column->getDataType());
        $this->assertFalse($this->column->isNullable());

        $this->assertFalse($this->column->hasComment());
        $this->assertNull($this->column->getComment());

        $this->assertFalse($this->column->hasDefault());
        $this->assertNull($this->column->getDefault());

        $this->assertFalse($this->column->hasTableName());
        $this->assertNull($this->column->getTableName());

        $this->assertNull($this->column->isZeroFill());
        $this->assertNull($this->column->isAutoIncrement());
    }

    public function testInitialPropertiesWithNumericDataType()
    {
        $dataType = $this->createMock(NumericTypeInterface::class);
        $dataType->method('doesAllowDefault')->willReturn(true);
        $column = new Column($this->name, $dataType);

        $this->assertFalse($column->isZeroFill());
        $this->assertFalse($column->isAutoIncrement());
    }

    public function testSetTableName()
    {
        $tableName = 'schnoop_tbl';
        $this->column->setTableName($tableName);

        $this->assertTrue($this->column->hasTableName());
        $this->assertSame($tableName, $this->column->getTableName());
    }

    public function testSetNullable()
    {
        $this->column->setNullable(true);
        $this->assertTrue($this->column->hasDefault());
        $this->assertNull($this->column->getDefault());
    }

    public function testSetDefault()
    {
        $default = 'foo';
        $castDefault = 'Foo';

        $this->dataType->expects($this->atLeastOnce())
            ->method('cast')
            ->with($default)
            ->willReturn($castDefault);

        $this->column->setDefault($default);

        $this->assertTrue($this->column->hasDefault());
        $this->assertSame($castDefault, $this->column->getDefault());
    }

    public function testSetDefaultArray()
    {
        $defaultArray = [
            'foo',
            'bar'
        ];

        $this->dataType->method('cast')
            ->will($this->onConsecutiveCalls($defaultArray[0], $defaultArray[1]));

        $this->column->setDefault($defaultArray);

        $this->assertSame($defaultArray, $this->column->getDefault());
    }

    public function testNotHasDefaultWhenNotAllowDefaultAndAllowNull()
    {
        $dataType = $this->createMock(DataTypeInterface::class);
        $dataType->method('doesAllowDefault')->willReturn(false);
        $column = new Column($this->name, $dataType);
        $column->setNullable(true);

        $this->assertFalse($column->hasDefault());
        $this->assertNull($this->column->getDefault());
    }


    /**
     * @expectedException \PHPUnit_Framework_Error_Warning
     * @expectedExceptionMessage Unable to set default value for the column as the data-type does not support a default.
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
            $mockDataType
        );

        $column->setDefault('foo');
    }

    public function testDefaultNotSetWhenNotAllowed()
    {
        /** @var DataTypeInterface|PHPUnit_Framework_MockObject_MockObject $mockDataType */
        $mockDataType = $this->createMock(DataTypeInterface::class);
        $mockDataType->method('cast')
            ->willReturn('');
        $mockDataType->method('doesAllowDefault')
            ->willReturn(false);

        $column = new Column(
            'foo',
            $mockDataType
        );

        @$column->setDefault('foo');
        $this->assertFalse($column->hasDefault());
        $this->assertNull($this->column->getDefault());
    }

    /**
     * Testing that no warning is triggered when setting default to null when a default is not allowed.
     * This is allowed to reduce the conditions in a column mapper.
     */
    public function testSetDefaultNullOkWhenDefaultNotAllowed()
    {
        /** @var DataTypeInterface|PHPUnit_Framework_MockObject_MockObject $mockDataType */
        $mockDataType = $this->createMock(DataTypeInterface::class);
        $mockDataType->method('cast')
            ->willReturn('');
        $mockDataType->method('doesAllowDefault')
            ->willReturn(false);

        $column = new Column(
            'foo',
            $mockDataType
        );

        $column->setDefault(null);
        $this->assertFalse($column->hasDefault());
        $this->assertNull($this->column->getDefault());
    }

    public function testSetZeroFill()
    {
        $dataType = $this->createMock(NumericTypeInterface::class);
        $dataType->method('doesAllowDefault')->willReturn(true);
        $column = new Column($this->name, $dataType);
        $column->setZeroFill(true);

        $this->assertTrue($column->isZeroFill());
    }

    /**
     * @expectedException \PHPUnit_Framework_Error_Warning
     * @expectedExceptionMessage Unable to set zero-fill property on the column as its data-type does not support it.
     */
    public function testWarningSetZeroFillOnUnsupportedType()
    {
        $this->column->setZeroFill(true);
    }

    public function testZeroFillNotSetOnSupportedType()
    {
        @$this->column->setZeroFill(true);

        $this->assertFalse($this->column->isZeroFill());
    }

    /**
     * Specifically testing that no problem is reported when setting ZeroFill
     * to false even when the type does not support it.
     */
    public function testNoWarningUnsetZeroFillOnUnsupportedType()
    {
        $this->column->setZeroFill(false);
        $this->assertFalse($this->column->isZeroFill());
    }

    public function testSetAutoIncrement()
    {
        $dataType = $this->createMock(NumericTypeInterface::class);
        $dataType->method('doesAllowDefault')->willReturn(true);
        $column = new Column($this->name, $dataType);
        $column->setAutoIncrement(true);

        $this->assertTrue($column->isAutoIncrement());
    }

    /**
     * @expectedException \PHPUnit_Framework_Error_Warning
     * @expectedExceptionMessage Unable to set autoincrement property on the column as its data-type does not support it.
     */
    public function testWarningSetAutoIncrementOnUnsupportedType()
    {
        $this->column->setAutoIncrement(true);
    }

    public function testAutoIncrementNotSetOnSupportedType()
    {
        @$this->column->setAutoIncrement(true);

        $this->assertFalse($this->column->isAutoIncrement());
    }

    /**
     * Specifically testing that no problem is reported when setting ZeroFill
     * to false even when the type does not support it.
     */
    public function testNoWarningUnsetAutoIncrementOnUnsupportedType()
    {
        $this->column->setAutoIncrement(false);
        $this->assertFalse($this->column->isAutoIncrement());
    }

    public function testSetComment()
    {
        $comment = 'Schnoop comment';
        $this->column->setComment($comment);

        $this->assertSame($comment, $this->column->getComment());
    }

    /**
     * @dataProvider DDLProvider
     * @param $column
     * @param $expectedDDL
     */
    public function testDDL(Column $column, $expectedDDL)
    {
        $this->assertSame($expectedDDL, (string)$column);
    }

    /**
     * @see testDDL
     * @return array
     */
    public function DDLProvider()
    {
        $default = '123';

        $mockNumericDataTypeAllowDefault = $this->createMock(NumericTypeInterface::class);
        $mockNumericDataTypeAllowDefault->method('doesAllowDefault')->willReturn(true);
        $mockNumericDataTypeAllowDefault->method('__toString')->willReturn('_DATATYPE_DDL_');
        $mockNumericDataTypeAllowDefault->method('cast')->willReturn($default);
        $mockNumericDataTypeAllowDefault->method('quote')->willReturn($default);

        $defaultArray = [
            'foo',
            'bar'
        ];

        $mockSetDataType = $this->createMock(SetType::class);
        $mockSetDataType->method('doesAllowDefault')->willReturn(true);
        $mockSetDataType->method('__toString')->willReturn('_DATATYPE_DDL_');
        $mockSetDataType->method('cast')
            ->will($this->onConsecutiveCalls($defaultArray[0], $defaultArray[1]));
        $mockSetDataType->method('quote')
            ->will($this->onConsecutiveCalls("'" . $defaultArray[0] . "'", "'". $defaultArray[1] . "'"));

        return [
            [
                $this->createColumn(
                    $this->name,
                    $mockNumericDataTypeAllowDefault,
                    false,
                    null,
                    false,
                    false,
                    null
                ),
                <<< SQL
`{$this->name}` _DATATYPE_DDL_ NOT NULL
SQL
            ],
            [
                $this->createColumn(
                    $this->name,
                    $mockNumericDataTypeAllowDefault,
                    true,
                    $default,
                    true,
                    true,
                    'Schnoop comment'
                ),
                <<< SQL
`{$this->name}` _DATATYPE_DDL_ ZEROFILL NULL DEFAULT 123 AUTO_INCREMENT COMMENT 'Schnoop comment'
SQL
            ],
            [
                $this->createColumn(
                    $this->name,
                    $mockSetDataType,
                    true,
                    $defaultArray,
                    null,
                    null,
                    null
                ),
                <<< SQL
`{$this->name}` _DATATYPE_DDL_ NULL DEFAULT ('foo','bar')
SQL
            ]
        ];
    }

    /**
     * @param string $name
     * @param DataTypeInterface $dataType
     * @param bool $nullable
     * @param mixed $default
     * @param bool|null $autoIncrement
     * @param bool|null $zeroFill
     * @param string $comment
     * @return Column
     */
    protected function createColumn(
        $name,
        DataTypeInterface $dataType,
        $nullable,
        $default,
        $autoIncrement,
        $zeroFill,
        $comment
    ) {
        $column = new Column($name, $dataType);
        $column->setNullable($nullable);
        $column->setDefault($default);

        if ($zeroFill !== null) {
            $column->setZeroFill($zeroFill);
        }

        if ($autoIncrement !== null) {
            $column->setAutoIncrement($autoIncrement);
        }

        $column->setComment($comment);

        return $column;
    }
}
