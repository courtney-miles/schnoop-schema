<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\Constraint\ConstraintInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\ForeignKey;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexedColumn;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexedColumnInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexInterface;
use MilesAsylum\SchnoopSchema\MySQL\Table\Table;
use MilesAsylum\SchnoopSchema\MySQL\Table\TableInterface;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\ConstraintTestCase;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;

class ForeignKeyTest extends ConstraintTestCase
{
    protected $constraintName = 'schnoop_idx';

    /**
     * @var ForeignKey
     */
    protected $foreignKey;

    public function setUp()
    {
        parent::setUp();

        $this->foreignKey = new ForeignKey($this->constraintName);
    }

    /**
     * @return ConstraintInterface
     */
    protected function getConstraint()
    {
        return $this->foreignKey;
    }

    protected function getConstraintName()
    {
        return $this->constraintName;
    }

    protected function getConstraintType()
    {
        return ConstraintInterface::CONSTRAINT_FOREIGN_KEY;
    }

    public function testInitialProperties()
    {
        parent::testInitialProperties();

        $this->assertSame(ForeignKey::REFERENCE_ACTION_RESTRICT, $this->foreignKey->getOnDeleteAction());
        $this->assertSame(ForeignKey::REFERENCE_ACTION_RESTRICT, $this->foreignKey->getOnUpdateAction());

        $this->assertFalse($this->foreignKey->hasReferenceTable());
        $this->assertNull($this->foreignKey->getReferenceTable());
        $this->assertSame([], $this->foreignKey->getReferenceColumnNames());
    }

    public function testSetOnDeleteAction()
    {
        $this->foreignKey->setOnDeleteAction(ForeignKey::REFERENCE_ACTION_CASCADE);
        $this->assertSame(ForeignKey::REFERENCE_ACTION_CASCADE, $this->foreignKey->getOnDeleteAction());
    }

    public function testSetOnUpdateAction()
    {
        $this->foreignKey->setOnUpdateAction(ForeignKey::REFERENCE_ACTION_CASCADE);
        $this->assertSame(ForeignKey::REFERENCE_ACTION_CASCADE, $this->foreignKey->getOnUpdateAction());
    }

    public function testSetReferenceTable()
    {
        $mockReferenceTable = $this->createMock(TableInterface::class);
        $mockReferenceTable->method('getName')->willReturn('ref_tbl');

        $referenceColumnNames = [
            'ref_col_a',
            'ref_col_b'
        ];

        $this->foreignKey->setReferenceColumns($mockReferenceTable, $referenceColumnNames);

        $this->assertTrue($this->foreignKey->hasReferenceTable());
        $this->assertSame($mockReferenceTable, $this->foreignKey->getReferenceTable());
        $this->assertSame($referenceColumnNames, $this->foreignKey->getReferenceColumnNames());
    }

    public function testDDL()
    {
        $expectedDDL = <<<SQL
CONSTRAINT `{$this->constraintName}` FOREIGN KEY (`col_a`,`col_b`) REFERENCES `ref_tbl` (`ref_col_a`,`ref_col_b`) ON DELETE RESTRICT ON UPDATE RESTRICT
SQL;

        $indexedColumnA = $this->createMock(IndexedColumn::class);
        $indexedColumnA->method('getColumnName')->willReturn('col_a');
        $indexedColumnB = $this->createMock(IndexedColumn::class);
        $indexedColumnB->method('getColumnName')->willReturn('col_b');

        $indexedColumns = [
            $indexedColumnA,
            $indexedColumnB
        ];

        $this->foreignKey->setIndexedColumns($indexedColumns);

        $mockReferenceTable = $this->createMock(TableInterface::class);
        $mockReferenceTable->method('getName')->willReturn('ref_tbl');

        $referenceColumnNames = [
            'ref_col_a',
            'ref_col_b'
        ];

        $this->foreignKey->setReferenceColumns($mockReferenceTable, $referenceColumnNames);

        $this->assertSame($expectedDDL, (string)$this->foreignKey);
    }
}
