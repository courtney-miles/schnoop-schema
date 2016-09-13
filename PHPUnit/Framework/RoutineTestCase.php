<?php

namespace MilesAsylum\SchnoopSchema\PHPUnit\Framework;

use MilesAsylum\SchnoopSchema\MySQL\Routine\RoutineInterface;
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
        $this->assertFalse($routine->hasComment());
        $this->assertNull($routine->getComment());
        $this->assertFalse($routine->isDeterministic());
        $this->assertSame(RoutineInterface::CONTAINS_SQL, $routine->getContains());
        $this->assertSame(RoutineInterface::SECURITY_DEFINER, $routine->getSqlSecurity());
        $this->assertSame('', $routine->getBody());
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
        $routine->setContains(RoutineInterface::CONTAINS_MODIFIES_SQL_DATA);

        $this->assertSame(RoutineInterface::CONTAINS_MODIFIES_SQL_DATA, $routine->getContains());
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
}
