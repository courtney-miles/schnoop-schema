<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Index;

use MilesAsylum\SchnoopSchema\MySQL\Column\ColumnInterface;
use MilesAsylum\SchnoopSchema\MySQL\Index\IndexedColumn;
use MilesAsylum\SchnoopSchema\MySQL\Index\IndexedColumnInterface;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;

class IndexedColumnTest extends SchnoopSchemaTestCase
{
    /**
     * @dataProvider constructProvider
     * @param ColumnInterface $column
     * @param int|null $length
     * @param string $collation
     * @param bool $expectHasLength
     */
    public function testConstructed(ColumnInterface $column, $length, $collation, $expectHasLength)
    {
        $indexedColumn = new IndexedColumn($column, $length, $collation);

        $this->assertSame($column, $indexedColumn->getColumn());
        $this->assertSame($column->getName(), $indexedColumn->getColumnName());
        $this->assertSame($expectHasLength, $indexedColumn->hasLength());
        $this->assertSame($length, $indexedColumn->getLength());
        $this->assertSame($collation, $indexedColumn->getCollation());
    }

    /**
     * @see testConstructed
     * @return array
     */
    public function constructProvider()
    {
        $mockColumn = $this->createMock(ColumnInterface::class);
        $mockColumn->method('getName')
            ->willReturn('schnoop_col');

        return [
            [
                $mockColumn,
                123,
                IndexedColumnInterface::COLLATION_ASC,
                true
            ]
        ];
    }
}
