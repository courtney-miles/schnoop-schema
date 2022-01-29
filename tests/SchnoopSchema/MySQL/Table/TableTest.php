<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Table;

use MilesAsylum\SchnoopSchema\MySQL\Constraint\ForeignKeyInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\UniqueIndex;
use MilesAsylum\SchnoopSchema\MySQL\DroppableInterface;
use MilesAsylum\SchnoopSchema\MySQL\HasDelimiterInterface;
use MilesAsylum\SchnoopSchema\MySQL\Table\TableInterface;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;
use MilesAsylum\SchnoopSchema\MySQL\Column\ColumnInterface;
use MilesAsylum\SchnoopSchema\MySQL\Table\Table;

class TableTest extends SchnoopSchemaTestCase
{
    /**
     * @var Table
     */
    protected $table;

    protected $name = 'schnoop_tbl';

    public function setUp(): void
    {
        parent::setUp();

        $this->table = new Table(
            $this->name
        );
    }

    public function testInitialProperties()
    {
        $this->assertSame($this->name, $this->table->getName());

        $this->assertFalse($this->table->hasDatabaseName());
        $this->assertNull($this->table->getDatabaseName());

        $this->assertFalse($this->table->hasEngine());
        $this->assertNull($this->table->getEngine());

        $this->assertFalse($this->table->hasDefaultCollation());
        $this->assertNull($this->table->getDefaultCollation());

        $this->assertFalse($this->table->hasRowFormat());
        $this->assertNull($this->table->getRowFormat());

        $this->assertFalse($this->table->hasComment());
        $this->assertNull($this->table->getComment());

        $this->assertSame([], $this->table->getColumns());

        $this->assertSame([], $this->table->getIndexes());
        $this->assertFalse($this->table->hasPrimaryKey());
        $this->assertNull($this->table->getPrimaryKey());

        $this->assertFalse($this->table->useFullyQualifiedName());
        $this->assertSame(HasDelimiterInterface::DEFAULT_DELIMITER, $this->table->getDelimiter());
        $this->assertSame(DroppableInterface::DDL_DROP_POLICY_DO_NOT_DROP, $this->table->getDropPolicy());
    }

    public function testSetNewName()
    {
        $newName = 'new_table_name';
        $this->table->setName($newName);

        $this->assertSame($newName, $this->table->getName());
    }

    public function testSetDatabaseName()
    {
        $databaseName = 'schnoop_db';
        $this->table->setDatabaseName($databaseName);

        $this->assertTrue($this->table->hasDatabaseName());
        $this->assertSame($databaseName, $this->table->getDatabaseName());
    }

    public function testSetEngine()
    {
        $this->table->setEngine(Table::ENGINE_INNODB);

        $this->assertTrue($this->table->hasEngine());
        $this->assertSame(Table::ENGINE_INNODB, $this->table->getEngine());
    }

    public function testSetEngineForcesCase()
    {
        $this->table->setEngine('InnoDB');

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

    public function testSetRowFormatForcesCase()
    {
        $this->table->setRowFormat('ComPacT');

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
            ->method('setTableName')
            ->with($this->table->getName());

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

        $this->assertFalse($this->table->hasIndex($constraintName));
        $this->assertNull($this->table->getIndex($constraintName));
    }

    public function testAddIndex()
    {
        $indexName = 'schnoop_idx';
        $indexDDL = '_IDX_DDL_';

        $mockIndex = $this->createMockIndex($indexName, $indexDDL);
        $mockIndex->expects($this->once())
            ->method('setTableName')
            ->with($this->table->getName());

        $this->table->addIndex($mockIndex);

        $this->assertTrue($this->table->hasIndex($indexName));
        $this->assertSame($mockIndex, $this->table->getIndex($indexName));
        $this->assertSame([$mockIndex], $this->table->getIndexes());
        $this->assertSame([$indexName], $this->table->getIndexList());
    }

    /**
     * @depends testAddIndex
     */
    public function testSetIndexes()
    {
        $indexNames = [
            'schnoop_idx1',
            'schnoop_idx2'
        ];

        $indexDDLs = [
            '_IDX_DDL_1_',
            '_IDX_DDL_2_'
        ];

        $mockIndexes = [
            $this->createMockIndex($indexNames[0], $indexDDLs[0]),
            $this->createMockIndex($indexNames[1], $indexDDLs[1])
        ];

        $this->table->setIndexes($mockIndexes);

        $this->assertSame($mockIndexes, $this->table->getIndexes());
        $this->assertSame($indexNames, $this->table->getIndexList());
    }

    public function testAddPrimaryKey()
    {
        $mockPrimaryKey = $this->createMock(UniqueIndex::class);
        $mockPrimaryKey->method('getName')->willReturn('primary');
        $this->table->addIndex($mockPrimaryKey);

        $this->assertTrue($this->table->hasPrimaryKey());
        $this->assertSame($mockPrimaryKey, $this->table->getPrimaryKey());
    }

    public function testAddForeignKey()
    {
        $foreignKeyName = 'schnoop_fk';
        $foreignKeyDDL = '_FK_DDL_';

        $mockForeignKey = $this->createMockForeignKey($foreignKeyName, $foreignKeyDDL);
        $mockForeignKey->expects($this->once())
            ->method('setTableName')
            ->with($this->table->getName());

        $this->table->addForeignKey($mockForeignKey);

        $this->assertTrue($this->table->hasForeignKey($foreignKeyName));
        $this->assertSame($mockForeignKey, $this->table->getForeignKey($foreignKeyName));
        $this->assertSame([$mockForeignKey], $this->table->getForeignKeys());
        $this->assertSame([$foreignKeyName], $this->table->getForeignKeyList());
    }

    /**
     * @depends testAddForeignKey
     */
    public function testSetForeignKey()
    {
        $foreignKeyNames = [
            'schnoop_fk1',
            'schnoop_fk2'
        ];

        $foreignKeyDDLs = [
            '_FK_DDL_1_',
            '_FK_DDL_2_'
        ];

        $mockForeignKeys = [
            $this->createMockForeignKey($foreignKeyNames[0], $foreignKeyDDLs[0]),
            $this->createMockForeignKey($foreignKeyNames[1], $foreignKeyDDLs[1])
        ];

        $this->table->setForeignKeys($mockForeignKeys);

        $this->assertSame($mockForeignKeys, $this->table->getForeignKeys());
        $this->assertSame($foreignKeyNames, $this->table->getForeignKeyList());
    }

    public function testSetUseFullyQualifiedName()
    {
        $this->table->setUseFullyQualifiedName(true);

        $this->assertTrue($this->table->useFullyQualifiedName());
    }

    public function testSetDelimiter()
    {
        $newDelimiter = '$$';
        $this->table->setDelimiter($newDelimiter);

        $this->assertSame($newDelimiter, $this->table->getDelimiter());
    }

    public function testSetDropPolicy()
    {
        $this->table->setDropPolicy(DroppableInterface::DDL_DROP_POLICY_DROP_IF_EXISTS);

        $this->assertSame(DroppableInterface::DDL_DROP_POLICY_DROP_IF_EXISTS, $this->table->getDropPolicy());
    }

    /**
     * @dataProvider getDDLTestData
     * @param Table $table
     * @param string $expectedDDL
     */
    public function testDDL(Table $table, $expectedDDL)
    {
        $this->assertSame($expectedDDL, $table->getCreateStatement());
    }

    public function testToStringAliasesGetDDL()
    {
        $ddl = '__ddl__';
        $mockTable = $this->getMockBuilder(Table::class)
            ->setConstructorArgs(
                [$this->name]
            )->setMethods(
                ['getCreateStatement']
            )->getMock();
        $mockTable->expects($this->once())
            ->method('getCreateStatement')
            ->willReturn($ddl);

        $this->assertSame($ddl, (string)$mockTable);
    }

    public function testExceptionOnUseFQNWhenDatabaseNameNotSet()
    {
        $this->expectExceptionMessage(
            'Unable to create DDL with fully-qualified-name because the database name has not been set.'
        );
        $this->expectException(\MilesAsylum\SchnoopSchema\MySQL\Exception\FQNException::class);

        $this->table->setUseFullyQualifiedName(true);

        $this->table->getCreateStatement();
    }

    /**
     * @see testDDL
     * @return array
     */
    public function getDDLTestData()
    {
        $databaseName = 'schnoop_db';

        $mockColumns = [
            $this->createMockColumn('schnoop_col1', '_COL_DDL_1_'),
            $this->createMockColumn('schnoop_col2', '_COL_DDL_2_')
        ];

        $mockIndexes = [
            $this->createMockIndex('schnoop_idx1', '_IDX_DDL_1_'),
            $this->createMockIndex('schnoop_idx2', '_IDX_DDL_2_')
        ];

        $mockForeignKeys = [
            $this->createMockForeignKey('schnoop_fk1', '_FK_DDL_1_'),
            $this->createMockForeignKey('schnoop_fk2', '_FK_DDL_2_')
        ];

        return [
            [
                $this->createTable(
                    $databaseName = 'schnoop_db',
                    '',
                    '',
                    '',
                    '',
                    [],
                    [],
                    [],
                    false,
                    HasDelimiterInterface::DEFAULT_DELIMITER,
                    DroppableInterface::DDL_DROP_POLICY_DO_NOT_DROP
                ),
                <<<SQL
CREATE TABLE `{$this->name}` (
);
SQL
            ],
            [
                $this->createTable(
                    $databaseName = 'schnoop_db',
                    TableInterface::ENGINE_INNODB,
                    TableInterface::ROW_FORMAT_COMPACT,
                    'utf8mb4_general_ci',
                    'Schnoop comment.',
                    $mockColumns,
                    $mockIndexes,
                    $mockForeignKeys,
                    false,
                    HasDelimiterInterface::DEFAULT_DELIMITER,
                    DroppableInterface::DDL_DROP_POLICY_DO_NOT_DROP
                ),
                <<<SQL
CREATE TABLE `{$this->name}` (
  _COL_DDL_1_,
  _COL_DDL_2_,
  _IDX_DDL_1_,
  _IDX_DDL_2_,
  _FK_DDL_1_,
  _FK_DDL_2_
)
ENGINE = INNODB
DEFAULT COLLATE = 'utf8mb4_general_ci'
ROW_FORMAT = COMPACT
COMMENT = 'Schnoop comment.';
SQL
            ],
            [
                $this->createTable(
                    $databaseName = 'schnoop_db',
                    '',
                    '',
                    '',
                    '',
                    [],
                    [],
                    [],
                    true,
                    '$$',
                    DroppableInterface::DDL_DROP_POLICY_DROP_IF_EXISTS
                ),
                <<<SQL
DROP TABLE IF EXISTS `{$databaseName}`.`{$this->name}`$$
CREATE TABLE `{$databaseName}`.`{$this->name}` (
)$$
SQL
            ],
            [
                $this->createTable(
                    $databaseName = 'schnoop_db',
                    '',
                    '',
                    '',
                    '',
                    [],
                    [],
                    [],
                    true,
                    '$$',
                    DroppableInterface::DDL_DROP_POLICY_DROP
                ),
                <<<SQL
DROP TABLE `{$databaseName}`.`{$this->name}`$$
CREATE TABLE `{$databaseName}`.`{$this->name}` (
)$$
SQL
            ],
        ];
    }

    /**
     * @param string $databaseName
     * @param string $engine
     * @param string $rowFormat
     * @param string $defaultCollation
     * @param string $comment
     * @param ColumnInterface[] $columns
     * @param IndexInterface[] $indexes
     * @param ForeignKeyInterface[] $foreignKeys
     * @param bool $useFQN
     * @param string $delimiter
     * @param string $dropPolicy
     * @return Table
     */
    protected function createTable(
        $databaseName,
        $engine,
        $rowFormat,
        $defaultCollation,
        $comment,
        array $columns,
        array $indexes,
        array $foreignKeys,
        $useFQN,
        $delimiter,
        $dropPolicy
    ) {
        $table = new Table($this->name);
        $table->setDatabaseName($databaseName);
        $table->setEngine($engine);
        $table->setRowFormat($rowFormat);
        $table->setDefaultCollation($defaultCollation);
        $table->setComment($comment);
        $table->setColumns($columns);
        $table->setIndexes($indexes);
        $table->setForeignKeys($foreignKeys);
        $table->setUseFullyQualifiedName($useFQN);
        $table->setDelimiter($delimiter);
        $table->setDropPolicy($dropPolicy);

        return $table;
    }
}
