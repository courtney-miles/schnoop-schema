<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Index;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopTestCase;
use MilesAsylum\SchnoopSchema\MySQL\Index\AbstractIndex;
use MilesAsylum\SchnoopSchema\MySQL\Index\IndexInterface;

class AbstractIndexTest extends SchnoopTestCase
{
    public function testConstructed()
    {
        $name = 'schnoop_idx';
        $indexedColumns = [];
        $indexType = IndexInterface::INDEX_TYPE_BTREE;
        $comment = 'Schnoop comment';

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
            $name, null, $indexedColumns, $indexType, $comment, $abstractIndex
        );
    }
}
