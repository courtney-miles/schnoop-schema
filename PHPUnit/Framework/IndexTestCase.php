<?php

namespace MilesAsylum\SchnoopSchema\PHPUnit\Framework;

use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexedColumn;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexInterface;

abstract class IndexTestCase extends ConstraintTestCase
{
    abstract protected function getIndexType();

    /**
     * @return IndexInterface
     */
    abstract protected function getIndex();

    protected function getConstraint()
    {
        return $this->getIndex();
    }

    public function testInitialProperties()
    {
        parent::testInitialProperties();

        $index = $this->getIndex();

        $this->assertSame($this->getIndexType(), $index->getIndexType(), 'Assertion on ' . get_class($index));

        $this->assertFalse($index->hasIndexedColumns(), 'Assertion on ' . get_class($index));
        $this->assertSame([], $index->getIndexedColumns(), 'Assertion on ' . get_class($index));

        $this->assertFalse($index->hasComment(), 'Assertion on ' . get_class($index));
        $this->assertNull($index->getComment(), 'Assertion on ' . get_class($index));
    }

    public function testSetIndexedColumns()
    {
        $indexedColumnA = $this->createMock(IndexedColumn::class);
        $indexedColumnA->method('getColumnName')->willReturn('col_a');
        $indexedColumnB = $this->createMock(IndexedColumn::class);
        $indexedColumnB->method('getColumnName')->willReturn('col_b');

        $indexedColumns = [
            $indexedColumnA,
            $indexedColumnB
        ];

        $index = $this->getConstraint();
        $index->setIndexedColumns($indexedColumns);

        $this->assertTrue($index->hasIndexedColumns());
        $this->assertSame($indexedColumns, $index->getIndexedColumns());
    }

    public function testSetIndexedColumnsReplacesPreviouslySetColumns()
    {
        $indexedColumnA = $this->createMock(IndexedColumn::class);
        $indexedColumnA->method('getColumnName')->willReturn('col_a');
        $indexedColumnB = $this->createMock(IndexedColumn::class);
        $indexedColumnB->method('getColumnName')->willReturn('col_b');
        $indexedColumnC = $this->createMock(IndexedColumn::class);
        $indexedColumnC->method('getColumnName')->willReturn('col_c');

        $indexedColumnsFirstSet = [
            $indexedColumnA,
            $indexedColumnB
        ];

        $indexedColumnsSecondSet = [
            $indexedColumnB,
            $indexedColumnC
        ];

        $index = $this->getConstraint();
        $index->setIndexedColumns($indexedColumnsFirstSet);
        $index->setIndexedColumns($indexedColumnsSecondSet);

        $this->assertSame($indexedColumnsSecondSet, $index->getIndexedColumns());
    }

    public function testAddIndexedColumns()
    {
        $indexedColumnA = $this->createMock(IndexedColumn::class);
        $indexedColumnA->method('getColumnName')->willReturn('col_a');
        $indexedColumnB = $this->createMock(IndexedColumn::class);
        $indexedColumnB->method('getColumnName')->willReturn('col_b');

        $indexedColumns = [
            $indexedColumnA,
            $indexedColumnB
        ];

        $index = $this->getConstraint();
        $index->addIndexedColumn($indexedColumnA);
        $index->addIndexedColumn($indexedColumnB);

        $this->assertTrue($index->hasIndexedColumns());
        $this->assertSame($indexedColumns, $index->getIndexedColumns());
    }

    public function testGetIndexedColumnNames()
    {
        $indexedColumnA = $this->createMock(IndexedColumn::class);
        $indexedColumnA->method('getColumnName')->willReturn('col_a');
        $indexedColumnB = $this->createMock(IndexedColumn::class);
        $indexedColumnB->method('getColumnName')->willReturn('col_b');

        $indexedColumns = [
            $indexedColumnA,
            $indexedColumnB
        ];

        $index = $this->getConstraint();
        $index->setIndexedColumns($indexedColumns);

        $this->assertSame(['col_a', 'col_b'], $index->getIndexedColumnNames());
    }

    public function testSetComment()
    {
        $comment = 'Schnoop comment';
        $index = $this->getIndex();
        $index->setComment($comment);

        $this->assertTrue($index->hasComment(), 'Assertion on ' . get_class($index));
        $this->assertSame($comment, $index->getComment(), 'Assertion on ' . get_class($index));
    }

    protected function indexDDLAsserts($ddlPrefix)
    {
        $index = $this->getIndex();

        $indexedColumnA = $this->createMock(IndexedColumn::class);
        $indexedColumnA->method('getColumnName')->willReturn('col_a');
        $indexedColumnB = $this->createMock(IndexedColumn::class);
        $indexedColumnB->method('getColumnName')->willReturn('col_b');

        $indexedColumns = [
            $indexedColumnA,
            $indexedColumnB
        ];

        $index->setIndexedColumns($indexedColumns);

        $comment = 'Schnoop comment';
        $index->setComment($comment);

        $expectedDDL = <<<SQL
{$ddlPrefix} (`col_a`,`col_b`) COMMENT '$comment'
SQL;


        $this->assertSame($expectedDDL, (string)$index);
    }
}
