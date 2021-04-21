<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Trigger;

use MilesAsylum\SchnoopSchema\MySQL\DroppableInterface;
use MilesAsylum\SchnoopSchema\MySQL\HasDelimiterInterface;
use MilesAsylum\SchnoopSchema\MySQL\SetVar\SqlMode;
use MilesAsylum\SchnoopSchema\MySQL\Trigger\Trigger;
use MilesAsylum\SchnoopSchema\MySQL\Trigger\TriggerInterface;
use PHPUnit\Framework\TestCase;

class TriggerTest extends TestCase
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
        $this->assertNull($this->trigger->getPositionContext());
        $this->assertNull($this->trigger->getPositionRelativeTo());

        $this->assertFalse($this->trigger->hasBody());
        $this->assertNull($this->trigger->getBody());

        $this->assertFalse($this->trigger->hasSqlMode());
        $this->assertNull($this->trigger->getSqlMode());

        $this->assertFalse($this->trigger->useFullyQualifiedName());
        $this->assertSame(HasDelimiterInterface::DEFAULT_DELIMITER, $this->trigger->getDelimiter());
        $this->assertSame(DroppableInterface::DDL_DROP_POLICY_DO_NOT_DROP, $this->trigger->getDropPolicy());
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
        $this->assertSame($relation, $this->trigger->getPositionContext());
        $this->assertSame($relativeTo, $this->trigger->getPositionRelativeTo());
    }

    public function testSetStatement()
    {
        $statement = 'SELECT 1;';
        $this->trigger->setBody($statement);

        $this->assertTrue($this->trigger->hasBody());
        $this->assertSame($statement, $this->trigger->getBody());
    }

    public function testSetSqlMode()
    {
        $mockSqlMode = $this->createMock(SqlMode::class);
        $this->trigger->setSqlMode($mockSqlMode);

        $this->assertTrue($this->trigger->hasSqlMode());
        $this->assertSame($mockSqlMode, $this->trigger->getSqlMode());

        return $this->trigger;
    }

    /**
     * @depends testSetSqlMode
     * @param Trigger $triggerWithSetSqlMode
     */
    public function testUnsetSqlMode(Trigger $triggerWithSetSqlMode)
    {
        $triggerWithSetSqlMode->unsetSqlMode();

        $this->assertFalse($triggerWithSetSqlMode->hasSqlMode());
        $this->assertNull($triggerWithSetSqlMode->getSqlMode());
    }

    public function testSetUseFullyQualifiedName()
    {
        $this->trigger->setUseFullyQualifiedName(true);

        $this->assertTrue($this->trigger->useFullyQualifiedName());
    }

    public function testSetDelimiter()
    {
        $newDelimiter = '$$';
        $this->trigger->setDelimiter($newDelimiter);

        $this->assertSame($newDelimiter, $this->trigger->getDelimiter());
    }

    public function testSetDropPolicy()
    {
        $this->trigger->setDropPolicy(DroppableInterface::DDL_DROP_POLICY_DROP_IF_EXISTS);

        $this->assertSame(DroppableInterface::DDL_DROP_POLICY_DROP_IF_EXISTS, $this->trigger->getDropPolicy());
    }

    /**
     * @dataProvider getDDLTestData
     * @param Trigger $trigger
     * @param $doMockSqlMode
     * @param $expectedDDL
     */
    public function testDDL(Trigger $trigger, $doMockSqlMode, $expectedDDL)
    {
        if ($doMockSqlMode) {
            $mockSqlMode = $this->createMock(SqlMode::class);
            $mockSqlMode->method('getSetStatements')->willReturn('__sql_mode_set__');
            $mockSqlMode->method('getRestoreStatements')->willReturn('__sql_mode_restore__');
            $trigger->setSqlMode($mockSqlMode);
        }

        $this->assertSame($expectedDDL, $trigger->getCreateStatement());
    }

    public function testToStringAliasesGetDDL()
    {
        $ddl = '__ddl__';
        $mockTrigger = $this->getMockBuilder(Trigger::class)
            ->setConstructorArgs(
                [$this->name, $this->timing, $this->event, $this->tableName]
            )->setMethods(
                ['getCreateStatement']
            )->getMock();
        $mockTrigger->expects($this->once())
            ->method('getCreateStatement')
            ->willReturn($ddl);

        $this->assertSame($ddl, (string)$mockTrigger);
    }

    /**
     * @expectedException \MilesAsylum\SchnoopSchema\MySQL\Exception\FQNException
     * @expectedExceptionMessage Unable to create DDL with fully-qualified-name because the database name has not been set.
     */
    public function testExceptionOnUseFQNWhenDatabaseNameNotSet()
    {
        $this->trigger->setUseFullyQualifiedName(true);

        $this->trigger->getCreateStatement();
    }

    /**
     * @see testDDL
     * @return array
     */
    public function getDDLTestData()
    {
        $databaseName = 'schnoop_db';
        return [
            [
                $this->createTrigger(
                    $this->name,
                    TriggerInterface::TIMING_BEFORE,
                    TriggerInterface::EVENT_INSERT,
                    'schnoop_tbl',
                    null,
                    null,
                    null,
                    null,
                    null,
                    false,
                    HasDelimiterInterface::DEFAULT_DELIMITER,
                    DroppableInterface::DDL_DROP_POLICY_DO_NOT_DROP
                ),
                false,
                <<<SQL
CREATE TRIGGER `{$this->name}` BEFORE INSERT
ON `schnoop_tbl` FOR EACH ROW
BEGIN
END;
SQL
            ],
            [
                $this->createTrigger(
                    $this->name,
                    TriggerInterface::TIMING_AFTER,
                    TriggerInterface::EVENT_UPDATE,
                    'schnoop_tbl',
                    $databaseName,
                    'root@localhost',
                    TriggerInterface::POSITION_FOLLOWS,
                    'schnoop_other_trigger',
                    'SELECT * FROM tbl;',
                    true,
                    '$$',
                    DroppableInterface::DDL_DROP_POLICY_DROP_IF_EXISTS
                ),
                true,
                <<<SQL
__sql_mode_set__
DROP TRIGGER IF EXISTS `{$databaseName}`.`{$this->name}`$$
CREATE DEFINER = root@localhost
TRIGGER `{$databaseName}`.`{$this->name}` AFTER UPDATE
ON `{$databaseName}`.`schnoop_tbl` FOR EACH ROW
FOLLOWS `schnoop_other_trigger`
BEGIN
SELECT * FROM tbl;
END$$
__sql_mode_restore__
SQL
            ],
            [
                $this->createTrigger(
                    $this->name,
                    TriggerInterface::TIMING_BEFORE,
                    TriggerInterface::EVENT_DELETE,
                    'schnoop_tbl',
                    null,
                    null,
                    null,
                    null,
                    null,
                    false,
                    HasDelimiterInterface::DEFAULT_DELIMITER,
                    DroppableInterface::DDL_DROP_POLICY_DROP
                ),
                false,
                <<<SQL
DROP TRIGGER `{$this->name}`;
CREATE TRIGGER `{$this->name}` BEFORE DELETE
ON `schnoop_tbl` FOR EACH ROW
BEGIN
END;
SQL
            ],
        ];
    }

    /**
     * @param $name
     * @param string $timing
     * @param string $event
     * @param string $tableName
     * @param string $databaseName
     * @param string $definer
     * @param string $positionContext
     * @param string $relativeTo
     * @param string $statement
     * @param bool $useFQN
     * @param string $delimiter
     * @param string $dropPolicy
     * @return Trigger
     */
    public function createTrigger(
        $name,
        $timing,
        $event,
        $tableName,
        $databaseName,
        $definer,
        $positionContext,
        $relativeTo,
        $statement,
        $useFQN,
        $delimiter,
        $dropPolicy
    ) {
        $trigger = new Trigger($name, $timing, $event, $tableName);
        $trigger->setDatabaseName($databaseName);
        $trigger->setDefiner($definer);
        $trigger->setPosition($positionContext, $relativeTo);
        $trigger->setBody($statement);
        $trigger->setUseFullyQualifiedName($useFQN);
        $trigger->setDelimiter($delimiter);
        $trigger->setDropPolicy($dropPolicy);

        return $trigger;
    }
}
