<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\Constraint\ForeignKeyColumn;
use PHPUnit\Framework\TestCase;

class ForeignKeyColumnTest extends TestCase
{
    protected $columnName = 'schnoop_col';

    protected $referenceColumnName = 'schnoop_ref_col';

    /**
     * @var ForeignKeyColumn
     */
    protected $foreignKeyColumn;

    public function setUp(): void
    {
        parent::setUp();

        $this->foreignKeyColumn = new ForeignKeyColumn($this->columnName, $this->referenceColumnName);
    }

    public function testInitialProperties(): void
    {
        $this->assertSame($this->columnName, $this->foreignKeyColumn->getColumnName());
        $this->assertSame($this->referenceColumnName, $this->foreignKeyColumn->getReferenceColumnName());
    }
}
