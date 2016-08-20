<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 27/06/16
 * Time: 7:43 AM
 */

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Table;

use MilesAsylum\SchnoopSchema\MySQL\Constraint\UniqueIndex;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\Column\ColumnInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\ConstraintInterface;
use MilesAsylum\SchnoopSchema\MySQL\Table\Table;

class TableTest extends SchnoopSchemaTestCase
{
    /**
     * @var Table
     */
    protected $table;

    protected $name = 'schnoop_tbl';

    public function setUp()
    {
        parent::setUp();

        $this->table = new Table(
            $this->name
        );
    }

    public function testInitialProperties()
    {
        $this->assertSame($this->name, $this->table->getName());

        $this->assertFalse($this->table->hasEngine());
        $this->assertNull($this->table->getEngine());

        $this->assertFalse($this->table->hasDefaultCollation());
        $this->assertNull($this->table->getDefaultCollation());

        $this->assertFalse($this->table->hasRowFormat());
        $this->assertNull($this->table->getRowFormat());

        $this->assertFalse($this->table->hasComment());
        $this->assertNull($this->table->getComment());

        $this->assertSame([], $this->table->getColumns());

        $this->assertSame([], $this->table->getConstraints());
        $this->assertFalse($this->table->hasPrimaryKey());
        $this->assertNull($this->table->getPrimaryKey());
    }

    public function testSetEngine()
    {
        $this->table->setEngine(Table::ENGINE_INNODB);

        $this->assertTrue($this->table->hasEngine());
        $this->assertSame(Table::ENGINE_INNODB, $this->table->getEngine());
    }

    public function testSetDefaultCollation()
    {
        $defaultCollation = 'utf8mb4_general_ci';

        $this->table->setDefaultCollation($defaultCollation);

        $this->assertTrue($this->table->hasDefaultCollation());
        $this->assertSame($defaultCollation, $this->table->getDefaultCollation());
    }

    public function testSetRowFormat()
    {
        $this->table->setRowFormat(Table::ROW_FORMAT_COMPACT);

        $this->assertTrue($this->table->hasRowFormat());
        $this->assertSame(Table::ROW_FORMAT_COMPACT, $this->table->getRowFormat());
    }

    public function testSetComment()
    {
        $comment = 'Schnoop comment';
        $this->table->setComment($comment);

        $this->assertTrue($this->table->hasComment());
        $this->assertSame($comment, $this->table->getComment());
    }

    public function testUndefinedColumn()
    {
        $columnName = 'schnoop_col';

        $this->assertFalse($this->table->hasColumn($columnName));
        $this->assertNull($this->table->getColumn($columnName));
    }

    public function testAddColumn()
    {
        $columnName = 'schnoop_col';
        $columnDDL = '_COL_DDL_';

        $mockColumn = $this->createMockColumn($columnName, $columnDDL);
        $mockColumn->expects($this->once())
            ->method('setTable')
            ->with($this->table);

        $this->table->addColumn($mockColumn);

        $this->assertTrue($this->table->hasColumn($columnName));
        $this->assertSame($mockColumn, $this->table->getColumn($columnName));
        $this->assertSame([$mockColumn], $this->table->getColumns());
        $this->assertSame([$columnName], $this->table->getColumnList());
    }

    /**
     * @depends testAddColumn
     */
    public function testSetColumns()
    {
        $columnNames = [
            'schnoop_col1',
            'schnoop_col2'
        ];

        $columnDDLs = [
            '_COL_DDL_1_',
            '_COL_DDL_2_'
        ];

        $mockColumns = [
            $this->createMockColumn($columnNames[0], $columnDDLs[0]),
            $this->createMockColumn($columnNames[1], $columnDDLs[1])
        ];

        $this->table->setColumns($mockColumns);

        $this->assertSame($mockColumns, $this->table->getColumns());
        $this->assertSame($columnNames, $this->table->getColumnList());
    }

    public function testUndefinedConstraint()
    {
        $constraintName = 'schnoop_idx';

        $this->assertFalse($this->table->hasConstraint($constraintName));
        $this->assertNull($this->table->getConstraint($constraintName));
    }

    public function testAddConstraint()
    {
        $constraintName = 'schnoop_idx';
        $constrainDDL = '_IDX_DDL_';

        $mockConstraint = $this->createMockConstraint($constraintName, $constrainDDL);
        $mockConstraint->expects($this->once())
            ->method('setTable')
            ->with($this->table);

        $this->table->addConstraint($mockConstraint);

        $this->assertTrue($this->table->hasConstraint($constraintName));
        $this->assertSame($mockConstraint, $this->table->getConstraint($constraintName));
        $this->assertSame([$mockConstraint], $this->table->getConstraints());
        $this->assertSame([$constraintName], $this->table->getConstraintList());
    }

    /**
     * @depends testAddConstraint
     */
    public function testSetConstraints()
    {
        $constraintNames = [
            'schnoop_idx1',
            'schnoop_idx2'
        ];

        $constraintDDLs = [
            '_IDX_DDL_1_',
            '_IDX_DDL_2_'
        ];

        $mockConstraints = [
            $this->createMockConstraint($constraintNames[0], $constraintDDLs[0]),
            $this->createMockConstraint($constraintNames[1], $constraintDDLs[1])
        ];

        $this->table->setConstraints($mockConstraints);

        $this->assertSame($mockConstraints, $this->table->getConstraints());
        $this->assertSame($constraintNames, $this->table->getConstraintList());
    }

    public function testAddPrimaryKey()
    {
        $mockPrimaryKey = $this->createMock(UniqueIndex::class);
        $mockPrimaryKey->method('getName')->willReturn('primary');
        $this->table->addConstraint($mockPrimaryKey);

        $this->assertTrue($this->table->hasPrimaryKey());
        $this->assertSame($mockPrimaryKey, $this->table->getPrimaryKey());
    }

    public function testDDL()
    {
        $table = new Table($this->name);
        $table->setEngine(Table::ENGINE_INNODB);
        $table->setRowFormat(Table::ROW_FORMAT_COMPACT);
        $table->setDefaultCollation('utf8mb4_general_ci');
        $table->setComment('Schnoop comment.');
        $table->setColumns(
            [
                $this->createMockColumn('schnoop_col1', '_COL_DDL_1_'),
                $this->createMockColumn('schnoop_col2', '_COL_DDL_2_')
            ]
        );
        $table->setConstraints(
            [
                $this->createMockConstraint('schnoop_idx1', '_IDX_DDL_1_'),
                $this->createMockConstraint('schnoop_idx2', '_IDX_DDL_2_')
            ]
        );

        $expectedDDL = <<<SQL
CREATE TABLE `{$this->name}` (
  _COL_DDL_1_,
  _COL_DDL_2_,
  _IDX_DDL_1_,
  _IDX_DDL_2_
)
ENGINE = INNODB
DEFAULT COLLATE = 'utf8mb4_general_ci'
ROW_FORMAT = COMPACT
COMMENT = 'Schnoop comment.';
SQL;

        $this->assertSame($expectedDDL, (string)$table);
    }

    protected function createMockColumn($columnName, $columnDDL)
    {
        $mockColumn = $this->createMock(ColumnInterface::class);
        $mockColumn->method('getName')->willReturn($columnName);
        $mockColumn->method('__toString')->willReturn($columnDDL);

        return $mockColumn;
    }
}
