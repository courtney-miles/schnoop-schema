<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Index;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopTestCase;
use MilesAsylum\SchnoopSchema\MySQL\Index\Index;
use MilesAsylum\SchnoopSchema\MySQL\Index\IndexInterface;

class IndexTest extends SchnoopTestCase
{
    public function testConstructed()
    {
        $name = 'schnoop_idx';
        $indexedColumns = [];
        $indexType = IndexInterface::INDEX_TYPE_BTREE;
        $comment = 'Schnoop comment';

        $index = new Index(
            $name,
            $indexedColumns,
            $indexType,
            $comment
        );

        $this->indexAsserts(
            $name,
            IndexInterface::INDEX_INDEX,
            $indexedColumns,
            $indexType,
            $comment,
            $index
        );
    }
}
