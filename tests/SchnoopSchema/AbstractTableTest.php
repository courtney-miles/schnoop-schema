<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema;

use MilesAsylum\SchnoopSchema\AbstractTable;
use MilesAsylum\SchnoopSchema\ColumnInterface;
use MilesAsylum\SchnoopSchema\IndexInterface;
use PHPUnit_Framework_MockObject_MockObject;

class AbstractTableTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractTable
     */
    protected $abstractCommonTable;

    protected $name = 'schnoop_table';

    /**
     * @var ColumnInterface[]
     */
    protected $mockColumns = [];

    protected $columnName = 'schnoop_column';

    /**
     * @var ColumnInterface[]
     */
    protected $mockIndexes = [];

    protected $indexName = 'schnoop_idx';

    public function setUp()
    {
        parent::setUp();

        $mockColumn = $this->createMock(ColumnInterface::class);
        $mockColumn->method('getName')->willReturn($this->columnName);
        $this->mockColumns[] = $mockColumn;

        $mockIndex = $this->createMock(IndexInterface::class);
        $mockIndex->method('getName')->willReturn($this->indexName);
        $this->mockIndexes[] = $mockIndex;

        $this->abstractCommonTable = $this->getMockForAbstractClass(
            AbstractTable::class,
            [
                $this->name,
                $this->mockColumns,
                $this->mockIndexes
            ]
        );
    }

    public function testConstruct()
    {
        $this->assertSame($this->name, $this->abstractCommonTable->getName());
        $this->assertSame($this->mockColumns, $this->abstractCommonTable->getColumns());
        $this->assertSame($this->mockIndexes, $this->abstractCommonTable->getIndexes());
    }

    public function testGetColumnList()
    {
        $this->assertSame([$this->columnName], $this->abstractCommonTable->getColumnList());
    }

    public function testGetColumns()
    {
        $this->assertSame($this->mockColumns, $this->abstractCommonTable->getColumns());
    }

    public function testHasColumn()
    {
        $this->assertTrue($this->abstractCommonTable->hasColumn($this->columnName));
    }

    public function testHasColumnNotFound()
    {
        $this->assertFalse($this->abstractCommonTable->hasColumn('bogus'));
    }

    public function testGetColumn()
    {
        $this->assertSame(
            reset($this->mockColumns),
            $this->abstractCommonTable->getColumn($this->columnName)
        );
    }

    public function testGetColumnNotFound()
    {
        $this->assertNull(
            $this->abstractCommonTable->getColumn('bogus')
        );
    }

    public function testGetIndexList()
    {
        $this->assertSame([$this->indexName], $this->abstractCommonTable->getIndexList());
    }

    public function testGetIndexes()
    {
        $this->assertSame($this->mockIndexes, $this->abstractCommonTable->getIndexes());
    }

    public function testHasIndex()
    {
        $this->assertTrue($this->abstractCommonTable->hasIndex($this->indexName));
    }

    public function testHasIndexNotFound()
    {
        $this->assertFalse($this->abstractCommonTable->hasIndex('bogus'));
    }

    public function testGetIndex()
    {
        $this->assertSame(
            reset($this->mockIndexes),
            $this->abstractCommonTable->getIndex($this->indexName)
        );
    }

    public function testGetIndexNotFound()
    {
        $this->assertNull($this->abstractCommonTable->getIndex('bogus'));
    }

    public function testHasPrimaryKeyNotFound()
    {
        $this->assertFalse($this->abstractCommonTable->hasPrimaryKey());
    }

    public function testHasPrimaryKeyFound()
    {
        $mockIndex = $this->createMock(IndexInterface::class);
        $mockIndex->method('getName')->willReturn('PRIMARY');

        /** @var AbstractTable|PHPUnit_Framework_MockObject_MockObject $abstractCommonTable */
        $abstractCommonTable = $this->getMockForAbstractClass(
            AbstractTable::class,
            [
                $this->name,
                $this->mockColumns,
                [$mockIndex]
            ]
        );

        $this->assertTrue($abstractCommonTable->hasPrimaryKey());
    }

    public function testGetPrimaryKeyNotFound()
    {
        $this->assertNull($this->abstractCommonTable->getPrimaryKey());
    }

    public function testGetPrimaryKeyFound()
    {
        $mockIndex = $this->createMock(IndexInterface::class);
        $mockIndex->method('getName')->willReturn('PRIMARY');

        /** @var AbstractTable|PHPUnit_Framework_MockObject_MockObject $abstractCommonTable */
        $abstractCommonTable = $this->getMockForAbstractClass(
            AbstractTable::class,
            [
                $this->name,
                $this->mockColumns,
                [$mockIndex]
            ]
        );

        $this->assertSame($mockIndex, $abstractCommonTable->getPrimaryKey());
    }
}
