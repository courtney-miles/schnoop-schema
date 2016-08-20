<?php

namespace MilesAsylum\SchnoopSchema\PHPUnit\Framework;

use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexedColumn;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexInterface;
use MilesAsylum\SchnoopSchema\MySQL\Table\TableInterface;

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

        $this->assertFalse($index->hasComment(), 'Assertion on ' . get_class($index));
        $this->assertNull($index->getComment(), 'Assertion on ' . get_class($index));
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
