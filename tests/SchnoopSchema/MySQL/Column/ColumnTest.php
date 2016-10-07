<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Column;

use MilesAsylum\SchnoopSchema\MySQL\Column\ColumnInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\SetType;
use MilesAsylum\SchnoopSchema\MySQL\DataType\TimestampType;
use MilesAsylum\SchnoopSchema\MySQL\DataType\TimeTypeInterface;
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

        $this->assertFalse($this->column->isOnUpdateCurrentTimestamp());

        $this->assertFalse($this->column->hasTableName());
        $this->assertNull($this->column->getTableName());

        $this->assertFalse($this->column->hasDatabaseName());
        $this->assertNull($this->column->getDatabaseName());

        $this->assertNull($this->column->isAutoIncrement());
    }

    public function testInitialPropertiesWithNumericDataType()
    {
        $dataType = $this->createMock(NumericTypeInterface::class);
        $dataType->method('doesAllowDefault')->willReturn(true);
        $column = new Column($this->name, $dataType);

        $this->assertFalse($column->isAutoIncrement());
    }

    public function testSetTableName()
    {
        $tableName = 'schnoop_tbl';
        $this->column->setTableName($tableName);

        $this->assertTrue($this->column->hasTableName());
        $this->assertSame($tableName, $this->column->getTableName());
    }

    public function testSetDatabaseName()
    {
        $databaseName = 'schnoop_db';
        $this->column->setDatabaseName($databaseName);

        $this->assertTrue($this->column->hasDatabaseName());
        $this->assertSame($databaseName, $this->column->getDatabaseName());
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
     * @expectedException \MilesAsylum\SchnoopSchema\MySQL\Exception\LogicException
     * @expectedExceptionMessage Unable to set default value for the column. The data-type "FOO" does not support a default.
     */
    public function testExceptionWhenSetDefaultWhenNotAllowed()
    {
        /** @var DataTypeInterface|PHPUnit_Framework_MockObject_MockObject $mockDataType */
        $mockDataType = $this->createMock(DataTypeInterface::class);
        $mockDataType->method('cast')
            ->willReturn('');
        $mockDataType->method('doesAllowDefault')
            ->willReturn(false);
        $mockDataType->method('getType')
            ->willReturn('FOO');


        $column = new Column(
            'foo',
            $mockDataType
        );

        $column->setDefault('foo');
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

    public function testSetOnUpdateCurrentTimestamp()
    {
        $mockTimeStamp = $this->createMock(TimestampType::class);
        $mockTimeStamp->method('doesAllowDefault')
            ->willReturn(true);
        $column = new Column($this->name, $mockTimeStamp);
        $column->setOnUpdateCurrentTimestamp(true);

        $this->assertTrue($column->isOnUpdateCurrentTimestamp());
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
     * @expectedException \MilesAsylum\SchnoopSchema\MySQL\Exception\LogicException
     * @expectedExceptionMessage Unable to set auto-increment property on the column. Data-type "FOO" does not support an auto-incrementing value.
     */
    public function testExceptionSetAutoIncrementOnUnsupportedType()
    {
        $this->dataType->method('getType')
            ->willReturn('FOO');

        $this->column->setAutoIncrement(true);
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

        $mockTimeType =  $this->createMock(TimeTypeInterface::class);
        $mockTimeType->method('doesAllowDefault')->willReturn(true);
        $mockTimeType->method('__toString')->willReturn('_DATATYPE_DDL_');
        $mockTimeType->method('cast')
            ->willReturn($default);
        $mockTimeType->method('quote')->willReturn($default);

        return [
            'Not NULL and no DEFAULT' => [
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
            'Null with DEFAULT' => [
                $this->createColumn(
                    $this->name,
                    $mockNumericDataTypeAllowDefault,
                    true,
                    $default,
                    false,
                    true,
                    'Schnoop comment'
                ),
                <<< SQL
`{$this->name}` _DATATYPE_DDL_ NULL DEFAULT 123 AUTO_INCREMENT COMMENT 'Schnoop comment'
SQL
            ],
            'NULL with DEFAULT array' => [
                $this->createColumn(
                    $this->name,
                    $mockSetDataType,
                    true,
                    $defaultArray,
                    false,
                    null,
                    null
                ),
                <<< SQL
`{$this->name}` _DATATYPE_DDL_ NULL DEFAULT ('foo','bar')
SQL
            ],
            'Not NULL with TIMESTAMP DEFAULT CURRENT_STAMP' => [
                $this->createColumn(
                    $this->name,
                    $mockTimeType,
                    false,
                    ColumnInterface::DEFAULT_CURRENT_TIMESTAMP,
                    false,
                    null,
                    null
                ),
                <<< SQL
`{$this->name}` _DATATYPE_DDL_ NOT NULL DEFAULT CURRENT_TIMESTAMP
SQL
            ],
            'Not NULL with ON UPDATE CURRENT_STAMP' => [
                $this->createColumn(
                    $this->name,
                    $mockTimeType,
                    false,
                    ColumnInterface::DEFAULT_CURRENT_TIMESTAMP,
                    true,
                    null,
                    null
                ),
                <<< SQL
`{$this->name}` _DATATYPE_DDL_ NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
SQL
            ]
        ];
    }

    /**
     * @param string $name
     * @param DataTypeInterface $dataType
     * @param bool $nullable
     * @param mixed $default
     * @param $onUpdateCurrentTimestamp
     * @param bool|null $autoIncrement
     * @param string $comment
     * @return Column
     * @internal param bool|null $zeroFill
     */
    protected function createColumn(
        $name,
        DataTypeInterface $dataType,
        $nullable,
        $default,
        $onUpdateCurrentTimestamp,
        $autoIncrement,
        $comment
    ) {
        $column = new Column($name, $dataType);
        $column->setNullable($nullable);
        $column->setDefault($default);
        $column->setOnUpdateCurrentTimestamp($onUpdateCurrentTimestamp);

        if ($autoIncrement !== null) {
            $column->setAutoIncrement($autoIncrement);
        }

        $column->setComment($comment);

        return $column;
    }
}
