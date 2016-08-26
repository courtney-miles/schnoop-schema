<?php

namespace MilesAsylum\SchnoopSchema\PHPUnit\Framework;

use MilesAsylum\SchnoopSchema\MySQL\Constraint\ForeignKeyInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexInterface;
use PHPUnit\Framework\TestCase;

class SchnoopSchemaTestCase extends TestCase
{
    /**
     * @param $indexName
     * @param $indexDDL
     * @return IndexInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function createMockIndex($indexName, $indexDDL)
    {
        $mockIndex = $this->createMock(IndexInterface::class);
        $mockIndex->method('getName')
            ->willReturn($indexName);
        $mockIndex->method('__toString')
            ->willReturn($indexDDL);

        return $mockIndex;
    }

    /**
     * @param $foreignKeyName
     * @param $foreignKeyDDL
     * @return ForeignKeyInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function createMockForeignKey($foreignKeyName, $foreignKeyDDL)
    {
        $mockForeignKey = $this->createMock(ForeignKeyInterface::class);
        $mockForeignKey->method('getName')
            ->willReturn($foreignKeyName);
        $mockForeignKey->method('__toString')
            ->willReturn($foreignKeyDDL);

        return $mockForeignKey;
    }
}
