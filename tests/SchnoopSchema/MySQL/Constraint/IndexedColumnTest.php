<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexedColumn;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;

class IndexedColumnTest extends SchnoopSchemaTestCase
{
    protected $columnName = 'schnoop_col';

    /**
     * @var IndexedColumn
     */
    protected $indexedColumn;

    public function setUp(): void
    {
        parent::setUp();

        $this->indexedColumn = new IndexedColumn($this->columnName);
    }

    public function testInitialProperties()
    {
        $this->assertSame($this->columnName, $this->indexedColumn->getColumnName());

        $this->assertFalse($this->indexedColumn->hasCollation());
        $this->assertNull($this->indexedColumn->getCollation());

        $this->assertFalse($this->indexedColumn->hasLength());
        $this->assertNull($this->indexedColumn->getLength());
    }

    public function testSetCollation()
    {
        $collation = IndexedColumn::COLLATION_ASC;
        $this->indexedColumn->setCollation($collation);

        $this->assertTrue($this->indexedColumn->hasCollation());
    }

    public function testSetLength()
    {
        $length = 123;
        $this->indexedColumn->setLength($length);

        $this->assertTrue($this->indexedColumn->hasLength());
        $this->assertSame($length, $this->indexedColumn->getLength());
    }
}
