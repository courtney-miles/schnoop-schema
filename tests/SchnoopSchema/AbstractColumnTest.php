<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema;

use MilesAsylum\SchnoopSchema\AbstractColumn;
use MilesAsylum\SchnoopSchema\DataTypeInterface;
use MilesAsylum\SchnoopSchema\TableInterface;
use PHPUnit_Framework_MockObject_MockObject;

class AbstractColumnTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractColumn
     */
    protected $abstractCommonColumn;

    protected $name = 'schnoop_column';

    /**
     * @var DataTypeInterface
     */
    protected $mockDataType;

    public function setUp()
    {
        parent::setUp();

        $this->mockDataType = $this->createMock(DataTypeInterface::class);

        $this->abstractCommonColumn = $this->getMockForAbstractClass(
            AbstractColumn::class,
            [$this->name, $this->mockDataType]
        );
    }

    public function testConstruct()
    {
        $this->assertSame($this->name, $this->abstractCommonColumn->getName());
        $this->assertSame($this->mockDataType, $this->abstractCommonColumn->getDataType());
        $this->assertNull($this->abstractCommonColumn->getTable());
    }

    public function testSetTable()
    {
        $tableName = 'schnoop_table';
        /** @var TableInterface|PHPUnit_Framework_MockObject_MockObject $mockTable */
        $mockTable = $this->createMock(TableInterface::class);
        $mockTable->method('getName')->willReturn($tableName);

        $this->abstractCommonColumn->setTable($mockTable);
        $this->assertSame($mockTable, $this->abstractCommonColumn->getTable());

        return $this->abstractCommonColumn;
    }

    /**
     * @depends testSetTable
     * @expectedException \MilesAsylum\SchnoopSchema\Exception\ColumnException
     * @expectedExceptionMessage Attempt made to attach column schnoop_column to table schnoop_table2 when it is already attached to schnoop_table
     * @param AbstractColumn $abstractCommonColumn
     */
    public function testExceptionWhenTableAlreadySet(AbstractColumn $abstractCommonColumn)
    {
        $tableName = 'schnoop_table2';
        /** @var TableInterface|PHPUnit_Framework_MockObject_MockObject $mockTable */
        $mockTable = $this->createMock(TableInterface::class);
        $mockTable->method('getName')->willReturn($tableName);

        $abstractCommonColumn->setTable($mockTable);
    }
}
