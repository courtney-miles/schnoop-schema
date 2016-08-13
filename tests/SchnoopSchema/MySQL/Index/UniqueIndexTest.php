<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Index;

use MilesAsylum\SchnoopSchema\MySQL\Index\IndexedColumnInterface;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\Index\IndexInterface;
use MilesAsylum\SchnoopSchema\MySQL\Index\UniqueIndex;

class UniqueIndexTest extends SchnoopSchemaTestCase
{
    protected $indexName = 'schnoop_idx';

    protected $indexedColumns = [];

    public function setUp()
    {
        parent::setUp();

        $this->indexedColumns[] = $this->createMockIndexedColumn('col_a', 123);
        $this->indexedColumns[] = $this->createMockIndexedColumn('col_b');
    }

    /**
     * @dataProvider constructedProvider
     * @param string|null $comment
     * @param bool $expectedHasComment
     * @param string $expectedDDL
     */
    public function testConstructed(
        $comment,
        $expectedHasComment,
        $expectedDDL
    ) {
        $uniqueIndex = new UniqueIndex(
            $this->indexName,
            $this->indexedColumns,
            IndexInterface::INDEX_TYPE_BTREE,
            $comment
        );

        $this->indexAsserts(
            $this->indexName,
            IndexInterface::INDEX_UNIQUE,
            $this->indexedColumns,
            IndexInterface::INDEX_TYPE_BTREE,
            $comment,
            $expectedHasComment,
            $expectedDDL,
            $uniqueIndex
        );
    }

    /**
     * @see testConstructed
     * @return array
     */
    public function constructedProvider()
    {
        return [
            [
                'schnoop_comment',
                true,
                "UNIQUE INDEX `{$this->indexName}` (`col_a`(123) ASC,`col_b` ASC) COMMENT 'schnoop_comment'"
            ],
            [
                '',
                false,
                "UNIQUE INDEX `{$this->indexName}` (`col_a`(123) ASC,`col_b` ASC)"
            ]
        ];
    }

    /**
     * @param string $columnName
     * @param int|null $length
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function createMockIndexedColumn($columnName, $length = null)
    {
        $mockIndexedColumn = $this->createMock(IndexedColumnInterface::class);
        $mockIndexedColumn->method('getColumnName')
            ->willReturn($columnName);
        $mockIndexedColumn->method('getCollation')
            ->willReturn(IndexedColumnInterface::COLLATION_ASC);
        $mockIndexedColumn->method('getLength')
            ->willReturn($length);
        $mockIndexedColumn->method('hasLength')
            ->willReturn($length !== null);

        return $mockIndexedColumn;
    }
}
