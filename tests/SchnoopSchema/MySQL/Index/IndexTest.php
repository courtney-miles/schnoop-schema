<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Index;

use MilesAsylum\SchnoopSchema\MySQL\Index\IndexedColumnInterface;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\Index\Index;
use MilesAsylum\SchnoopSchema\MySQL\Index\IndexInterface;

class IndexTest extends SchnoopSchemaTestCase
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
     * @param string $indexName
     * @param string|null $comment
     * @param bool $expectedHasComment
     * @param string $expectedDDL
     */
    public function testConstructed(
        $indexName,
        $comment,
        $expectedHasComment,
        $expectedDDL
    ) {
        $index = new Index(
            $indexName,
            $this->indexedColumns,
            IndexInterface::INDEX_TYPE_BTREE,
            $comment
        );

        $this->indexAsserts(
            $indexName,
            IndexInterface::INDEX_INDEX,
            $this->indexedColumns,
            IndexInterface::INDEX_TYPE_BTREE,
            $comment,
            $expectedHasComment,
            $expectedDDL,
            $index
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
                $this->indexName,
                'schnoop_comment',
                true,
                "INDEX `{$this->indexName}` USING BTREE (`col_a`(123) ASC,`col_b` ASC) COMMENT 'schnoop_comment'"
            ],
            [
                $this->indexName,
                '',
                false,
                "INDEX `{$this->indexName}` USING BTREE (`col_a`(123) ASC,`col_b` ASC)"
            ],

            [
                'primary',
                '',
                false,
                "PRIMARY KEY USING BTREE (`col_a`(123) ASC,`col_b` ASC)"
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
