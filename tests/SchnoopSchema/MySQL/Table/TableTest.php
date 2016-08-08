<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 27/06/16
 * Time: 7:43 AM
 */

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Table;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopTestCase;
use MilesAsylum\SchnoopSchema\MySQL\Column\ColumnInterface;
use MilesAsylum\SchnoopSchema\MySQL\Index\IndexInterface;
use MilesAsylum\SchnoopSchema\MySQL\Table\Table;

class TableTest extends SchnoopTestCase
{
    /**
     * @var Table
     */
    protected $table;

    protected $name = 'schnoop_tbl';

    /**
     * @var ColumnInterface[]
     */
    protected $mockColumns = [];

    protected $columnName = 'schnoop_col';

    /**
     * @var IndexInterface[]
     */
    protected $mockIndexes = [];

    protected $indexName = 'schnoop_idx';

    protected $engine = 'InnoDB';

    protected $rowFormat = 'Compact';

    protected $defaultCollation = 'utf8mb4_general_ci';

    protected $comment = 'This is a comment';

    protected $ddl;

    public function setUp()
    {
        parent::setUp();

        $mockColumn = $this->createMock(ColumnInterface::class);
        $mockColumn->method('getName')
            ->willReturn($this->columnName);
        $mockColumn->method('__toString')
            ->willReturn('__column_ddl__');
        $mockColumn->expects($this->once())
            ->method('setTable')
            ->with($this->isInstanceOf(Table::class));
        $this->mockColumns[] = $mockColumn;

        $mockIndex = $this->createMock(IndexInterface::class);
        $mockIndex->method('getName')
            ->willReturn($this->indexName);
        $mockIndex->method('__toString')
            ->willReturn('__index_ddl__');
        $this->mockIndexes[] = $mockIndex;

        $this->table = new Table(
            $this->name,
            $this->mockColumns,
            $this->mockIndexes,
            $this->engine,
            $this->rowFormat,
            $this->defaultCollation,
            $this->comment
        );

        $this->ddl = <<< SQL
CREATE TABLE `{$this->name}` (
    __column_ddl__,
    __index_ddl__
)
ENGINE = INNODB
DEFAULT COLLATE = '{$this->defaultCollation}'
ROW_FORMAT = COMPACT
COMMENT = '{$this->comment}';
SQL;
    }

    public function testConstructed()
    {
        $this->assertSame($this->name, $this->table->getName());
        $this->assertSame($this->mockColumns, $this->table->getColumns());
        $this->assertSame($this->engine, $this->table->getEngine());
        $this->assertSame($this->rowFormat, $this->table->getRowFormat());
        $this->assertSame($this->defaultCollation, $this->table->getDefaultCollation());
        $this->assertSame($this->comment, $this->table->getComment());
        $this->assertSame($this->ddl, (string)$this->table);
    }

    public function testGetColumn()
    {
        $this->assertSame(reset($this->mockColumns), $this->table->getColumn($this->columnName));
    }

    public function testGetIndex()
    {
        $this->assertSame(reset($this->mockIndexes), $this->table->getIndex($this->indexName));
    }
}
