<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Index;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopTestCase;
use MilesAsylum\SchnoopSchema\MySQL\Index\IndexInterface;
use MilesAsylum\SchnoopSchema\MySQL\Index\UniqueIndex;

class UniqueIndexTest extends SchnoopTestCase
{
    public function testConstructed()
    {
        $name = 'schnoop_idx';
        $indexedColumns = [];
        $indexType = IndexInterface::INDEX_TYPE_BTREE;
        $comment = 'Schnoop comment';

        $uniqueIndex = new UniqueIndex(
            $name,
            $indexedColumns,
            $indexType,
            $comment
        );

        $this->indexAsserts(
            $name, IndexInterface::INDEX_UNIQUE, $indexedColumns, $indexType, $comment, $uniqueIndex
        );
    }
}
