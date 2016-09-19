<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Trigger;

use MilesAsylum\SchnoopSchema\MySQL\SetVar\SqlMode;
use MilesAsylum\SchnoopSchema\MySQL\Trigger\Trigger;
use MilesAsylum\SchnoopSchema\MySQL\Trigger\TriggerInterface;

class TriggerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Trigger
     */
    protected $trigger;

    protected $name = 'schnoop_trigger';

    protected $timing = 'BEFORE';

    protected $event = 'INSERT';

    protected $tableName = 'schnoop_tbl';

    public function setUp()
    {
        parent::setUp();

        $this->trigger = new Trigger(
            $this->name,
            $this->timing,
            $this->event,
            $this->tableName
        );
    }

    public function testInitialProperties()
    {
        $this->assertSame($this->name, $this->trigger->getName());
        $this->assertSame($this->timing, $this->trigger->getTiming());
        $this->assertSame($this->event, $this->trigger->getEvent());
        $this->assertSame($this->tableName, $this->trigger->getTableName());

        $this->assertFalse($this->trigger->hasDatabaseName());
        $this->assertNull($this->trigger->getDatabaseName());
        
        $this->assertFalse($this->trigger->hasDefiner());
        $this->assertNull($this->trigger->getDefiner());

        $this->assertFalse($this->trigger->hasPosition());
        $this->assertNull($this->trigger->getPositionRelation());
        $this->assertNull($this->trigger->getPositionRelativeTo());

        $this->assertFalse($this->trigger->hasStatement());
        $this->assertNull($this->trigger->getStatement());

        $this->assertFalse($this->trigger->hasSqlMode());
        $this->assertNull($this->trigger->getSqlMode());
    }

    public function testConstants()
    {
        $this->assertSame('CURRENT_USER', TriggerInterface::DEFINER_CURRENT_USER);
        $this->assertSame('BEFORE', TriggerInterface::TIMING_BEFORE);
        $this->assertSame('AFTER', TriggerInterface::TIMING_AFTER);
        $this->assertSame('INSERT', TriggerInterface::EVENT_INSERT);
        $this->assertSame('UPDATE', TriggerInterface::EVENT_UPDATE);
        $this->assertSame('DELETE', TriggerInterface::EVENT_DELETE);
        $this->assertSame('FOLLOWS', TriggerInterface::POSITION_FOLLOWS);
        $this->assertSame('PRECEDES', TriggerInterface::POSITION_PRECEDES);
    }
    
    public function testSetDatabaseName()
    {
        $databaseName = 'schnoop_db';
        $this->trigger->setDatabaseName($databaseName);
        
        $this->assertTrue($this->trigger->hasDatabaseName());
        $this->assertSame($databaseName, $this->trigger->getDatabaseName());
    }

    public function testSetDefiner()
    {
        $definer = 'root@localhost';
        $this->trigger->setDefiner($definer);
        
        $this->assertTrue($this->trigger->hasDefiner());
        $this->assertSame($definer, $this->trigger->getDefiner());
    }

    public function testSetPosition()
    {
        $relation = 'FOLLOWS';
        $relativeTo = 'schnoop_other_trigger';
        $this->trigger->setPosition($relation, $relativeTo);

        $this->assertTrue($this->trigger->hasPosition());
        $this->assertSame($relation, $this->trigger->getPositionRelation());
        $this->assertSame($relativeTo, $this->trigger->getPositionRelativeTo());
    }

    public function testSetStatement()
    {
        $statement = 'SELECT 1;';
        $this->trigger->setStatement($statement);

        $this->assertTrue($this->trigger->hasStatement());
        $this->assertSame($statement, $this->trigger->getStatement());
    }

    public function testSetSqlMode()
    {
        $mockSqlMode = $this->createMock(SqlMode::class);
        $this->trigger->setSqlMode($mockSqlMode);

        $this->assertTrue($this->trigger->hasSqlMode());
        $this->assertSame($mockSqlMode, $this->trigger->getSqlMode());
    }

    public function testGetBasicDDL()
    {
        $expectedDDL = <<<SQL
CREATE TRIGGER `{$this->name}` {$this->timing} {$this->event}
ON `{$this->tableName}` FOR EACH ROW
;
SQL;

        $this->assertSame($expectedDDL, $this->trigger->getDDL());
    }

    public function testGetFullDDL()
    {
        $databaseName = 'schnoop_db';
        $definer = 'root@localhost';
        $relation = 'FOLLOWS';
        $relativeTo = 'schnoop_other_trigger';
        $statement = 'SELECT 1;';
        $setModeStmts = '_SET_MODE_;';
        $restoreModeStmts = '_RESTORE_MODE_;';

        $mockSqlMode = $this->createMock(SqlMode::class);
        $mockSqlMode->method('getAssignStmt')
            ->willReturn($setModeStmts);
        $mockSqlMode->method('getRestoreStmt')
            ->willReturn($restoreModeStmts);

        $expectedDDL = <<<SQL
{$setModeStmts}
CREATE DEFINER = {$definer}
TRIGGER `{$this->name}` {$this->timing} {$this->event}
ON `{$databaseName}`.`{$this->tableName}` FOR EACH ROW
{$relation} `{$relativeTo}`
{$statement}
@@
{$restoreModeStmts}
SQL;

        $this->trigger->setDatabaseName($databaseName);
        $this->trigger->setDefiner($definer);
        $this->trigger->setPosition($relation, $relativeTo);
        $this->trigger->setStatement($statement);
        $this->trigger->setSqlMode($mockSqlMode);

        $this->assertSame($expectedDDL, $this->trigger->getDDL(true, '@@'));
    }

    public function testToString()
    {
        $expectedDDL = <<<SQL
CREATE TRIGGER `{$this->name}` {$this->timing} {$this->event}
ON `{$this->tableName}` FOR EACH ROW
;
SQL;

        $this->assertSame($expectedDDL, (string)$this->trigger);
    }
}
