<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Index;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopTestCase;
use MilesAsylum\SchnoopSchema\MySQL\Index\FullTextIndex;
use MilesAsylum\SchnoopSchema\MySQL\Index\IndexInterface;

class FullTextIndexTest extends SchnoopTestCase
{
    public function testConstruct()
    {
        $name = 'schnoop_idx';
        $indexedColumns = [];
        $comment = 'Schnoop comment';

        $fullTextIndex = new FullTextIndex(
            $name,
            $indexedColumns,
            $comment
        );

        $this->indexAsserts(
            $name, IndexInterface::INDEX_FULLTEXT, $indexedColumns, IndexInterface::INDEX_TYPE_FULLTEXT, $comment,
            $fullTextIndex
        );
    }
}
