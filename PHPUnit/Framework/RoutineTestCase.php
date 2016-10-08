<?php

namespace MilesAsylum\SchnoopSchema\PHPUnit\Framework;

use MilesAsylum\SchnoopSchema\MySQL\DroppableInterface;
use MilesAsylum\SchnoopSchema\MySQL\HasDelimiterInterface;
use MilesAsylum\SchnoopSchema\MySQL\MySQLInterface;
use MilesAsylum\SchnoopSchema\MySQL\Routine\RoutineInterface;
use MilesAsylum\SchnoopSchema\MySQL\SetVar\SqlMode;
use PHPUnit\Framework\TestCase;

abstract class RoutineTestCase extends TestCase
{
    /**
     * @return RoutineInterface
     */
    abstract protected function getRoutine();

    /**
     * @return RoutineInterface
     */
    abstract protected function createRoutine();

    abstract protected function getExpectedName();

    public function testInitialProperties()
    {
        $routine = $this->getRoutine();

        $this->assertSame($this->getExpectedName(), $routine->getName());
        $this->assertFalse($routine->hasDatabaseName());
        $this->assertNull($routine->getDatabaseName());
        $this->assertSame(RoutineInterface::DEFINER_CURRENT_USER, $routine->getDefiner());
        $this->assertTrue($routine->hasDefiner());
        $this->assertFalse($routine->hasComment());
        $this->assertNull($routine->getComment());
        $this->assertFalse($routine->isDeterministic());
        $this->assertSame(RoutineInterface::DATA_ACCESS_CONTAINS_SQL, $routine->getDataAccess());
        $this->assertSame(RoutineInterface::SECURITY_DEFINER, $routine->getSqlSecurity());
        $this->assertSame('', $routine->getBody());
        $this->assertFalse($routine->hasSqlMode());
        $this->assertNull($routine->getSqlMode());
        $this->assertFalse($routine->useFullyQualifiedName());
        $this->assertSame(HasDelimiterInterface::DEFAULT_DELIMITER, $routine->getDelimiter());
        $this->assertSame(DroppableInterface::DDL_DROP_POLICY_DO_NOT_DROP, $routine->getDropPolicy());
    }

    public function testSetDatabaseName()
    {
        $databaseName = 'schnoop_db';
        $this->getRoutine()->setDatabaseName($databaseName);

        $this->assertTrue($this->getRoutine()->hasDatabaseName());
        $this->assertSame($databaseName, $this->getRoutine()->getDatabaseName());
    }

    public function testSetDefiner()
    {
        $definer = 'me@example';
        $routine = $this->getRoutine();
        $routine->setDefiner($definer);

        $this->assertSame($definer, $routine->getDefiner());
    }

    public function testSetComment()
    {
        $comment = 'Routine comment.';
        $routine = $this->getRoutine();
        $routine->setComment($comment);

        $this->assertTrue($routine->hasComment());
        $this->assertSame($comment, $routine->getComment());
    }

    public function testSetDeterministic()
    {
        $routine = $this->getRoutine();
        $routine->setDeterministic(true);

        $this->assertTrue($routine->isDeterministic());
    }

    public function testSetContains()
    {
        $routine = $this->getRoutine();
        $routine->setDataAccess(RoutineInterface::DATA_ACCESS_MODIFIES_SQL_DATA);

        $this->assertSame(RoutineInterface::DATA_ACCESS_MODIFIES_SQL_DATA, $routine->getDataAccess());
    }

    public function testSetSqlSecurity()
    {
        $routine = $this->getRoutine();
        $routine->setSqlSecurity(RoutineInterface::SECURITY_INVOKER);

        $this->assertSame(RoutineInterface::SECURITY_INVOKER, $routine->getSqlSecurity());
    }

    public function testSetBody()
    {
        $body = "Hello world.";
        $routine = $this->getRoutine();
        $routine->setBody($body);

        $this->assertSame($body, $routine->getBody());
    }

    public function testSetSQLMode()
    {
        $mockSqlMode = $this->createMock(SqlMode::class);
        $routine = $this->getRoutine();
        $routine->setSqlMode($mockSqlMode);

        $this->assertTrue($routine->hasSqlMode());
        $this->assertSame($mockSqlMode, $routine->getSqlMode());

        return $routine;
    }

    /**
     * @depends testSetSQLMode
     * @param RoutineInterface $routineWithSqlMode
     */
    public function testUnsetSqlMode(RoutineInterface $routineWithSqlMode)
    {
        $routineWithSqlMode->unsetSqlMode();

        $this->assertFalse($routineWithSqlMode->hasSqlMode());
        $this->assertNull($routineWithSqlMode->getSqlMode());
    }

    public function testSetUseFullyQualifiedName()
    {
        $routine = $this->getRoutine();
        $routine->setUseFullyQualifiedName(true);

        $this->assertTrue($routine->useFullyQualifiedName());
    }

    public function testSetDDLDelimiter()
    {
        $routine = $this->getRoutine();
        $routine->setDelimiter('@@');

        $this->assertSame('@@', $routine->getDelimiter());
    }

    public function testSetDDLDropPolicy()
    {
        $routine = $this->getRoutine();
        $routine->setDropPolicy(RoutineInterface::DDL_DROP_POLICY_DROP_IF_EXISTS);

        $this->assertSame(RoutineInterface::DDL_DROP_POLICY_DROP_IF_EXISTS, $routine->getDropPolicy());
    }
}
