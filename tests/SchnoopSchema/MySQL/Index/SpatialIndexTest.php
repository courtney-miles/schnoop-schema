<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Index;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopTestCase;
use MilesAsylum\SchnoopSchema\MySQL\Index\IndexInterface;
use MilesAsylum\SchnoopSchema\MySQL\Index\SpatialIndex;

class SpatialIndexTest extends SchnoopTestCase
{
    public function testConstructed()
    {
        $name = 'schnoop_idx';
        $indexedColumns = [];
        $comment = 'Schnoop comment';

        $spatialIndex = new SpatialIndex(
            $name,
            $indexedColumns,
            $comment
        );

        $this->indexAsserts(
            $name, IndexInterface::INDEX_SPATIAL, $indexedColumns, IndexInterface::INDEX_TYPE_RTREE, $comment,
            $spatialIndex
        );
    }
}
