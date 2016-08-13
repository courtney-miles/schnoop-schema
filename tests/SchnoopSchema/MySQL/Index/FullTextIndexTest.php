<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Index;

use MilesAsylum\SchnoopSchema\ColumnInterface;
use MilesAsylum\SchnoopSchema\MySQL\Index\IndexedColumnInterface;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\Index\FullTextIndex;
use MilesAsylum\SchnoopSchema\MySQL\Index\IndexInterface;

class FullTextIndexTest extends SchnoopSchemaTestCase
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
     * @param $comment
     * @param $expectedHasComment
     * @param $expectedDDL
     */
    public function testConstructed(
        $comment,
        $expectedHasComment,
        $expectedDDL
    ) {
        $fullTextIndex = new FullTextIndex(
            $this->indexName,
            $this->indexedColumns,
            $comment
        );

        $this->indexAsserts(
            $this->indexName,
            IndexInterface::INDEX_FULLTEXT,
            $this->indexedColumns,
            IndexInterface::INDEX_TYPE_FULLTEXT,
            $comment,
            $expectedHasComment,
            $expectedDDL,
            $fullTextIndex
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
                "FULLTEXT `{$this->indexName}` (`col_a`(123) ASC,`col_b` ASC) COMMENT 'schnoop_comment'"
            ],
            [
                '',
                false,
                "FULLTEXT `{$this->indexName}` (`col_a`(123) ASC,`col_b` ASC)"
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
