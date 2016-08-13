<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Index;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\Index\AbstractIndex;
use MilesAsylum\SchnoopSchema\MySQL\Index\IndexInterface;

class AbstractIndexTest extends SchnoopSchemaTestCase
{
    /**
     * @dataProvider constructedProvider
     * @param string|null $comment
     * @param bool $expectHasComment
     */
    public function testConstructed(
        $comment,
        $expectHasComment
    ) {
        $name = 'schnoop_idx';
        $indexedColumns = [];
        $indexType = IndexInterface::INDEX_TYPE_BTREE;

        $abstractIndex = $this->getMockForAbstractClass(
            AbstractIndex::class,
            [
                $name,
                $indexedColumns,
                $indexType,
                $comment
            ]
        );

        $this->indexAsserts(
            $name,
            null,
            $indexedColumns,
            $indexType,
            $comment,
            $expectHasComment,
            null,
            $abstractIndex
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
                'Schnoop comment',
                true
            ],
            [
                '',
                false
            ],
            [
                null,
                false
            ]
        ];
    }
}
