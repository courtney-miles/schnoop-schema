<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\DroppableInterface;
use MilesAsylum\SchnoopSchema\MySQL\HasDelimiterInterface;
use MilesAsylum\SchnoopSchema\MySQL\MySQLInterface;
use MilesAsylum\SchnoopSchema\MySQL\Routine\ProcedureParameterInterface;
use MilesAsylum\SchnoopSchema\MySQL\Routine\RoutineProcedure;
use MilesAsylum\SchnoopSchema\MySQL\Routine\RoutineInterface;
use MilesAsylum\SchnoopSchema\MySQL\SetVar\SqlMode;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\RoutineTestCase;
use PHPUnit_Framework_MockObject_MockObject;

class RoutineProcedureTest extends RoutineTestCase
{
    protected $name = 'schnoop_proc';

    /**
     * @var RoutineProcedure
     */
    protected $procedure;

    public function setUp()
    {
        parent::setUp();

        $this->procedure = $this->createRoutine();
    }

    /**
     * @return RoutineInterface
     */
    protected function getRoutine()
    {
        return $this->procedure;
    }

    /**
     * @return RoutineProcedure
     */
    protected function createRoutine()
    {
        return new RoutineProcedure($this->name);
    }

    protected function getExpectedName()
    {
        return $this->name;
    }

    public function testInitialProperties()
    {
        parent::testInitialProperties();

        $this->assertFalse($this->procedure->hasParameters());
        $this->assertSame([], $this->procedure->getParameters());
    }

    public function testSetParameters()
    {
        /** @var ProcedureParameterInterface[]|PHPUnit_Framework_MockObject_MockObject[] $parameters */
        $parameters = [
            $this->createMock(ProcedureParameterInterface::class),
            $this->createMock(ProcedureParameterInterface::class)
        ];

        $parameters[0]->method('getName')
            ->willReturn('param_1');
        $parameters[0]->method('getName')
            ->willReturn('param_2');

        $this->procedure->setParameters($parameters);

        $this->assertTrue($this->procedure->hasParameters());
        $this->assertSame($parameters, $this->procedure->getParameters());
    }

    public function testAddParameter()
    {
        /** @var ProcedureParameterInterface[]|PHPUnit_Framework_MockObject_MockObject[] $parameters */
        $parameters = [
            $this->createMock(ProcedureParameterInterface::class),
            $this->createMock(ProcedureParameterInterface::class)
        ];

        $parameters[0]->method('getName')
            ->willReturn('param_1');
        $parameters[0]->method('getName')
            ->willReturn('param_2');

        $this->procedure->setParameters([$parameters[0]]);
        $this->procedure->addParameter($parameters[1]);

        $this->assertSame($parameters, $this->procedure->getParameters());
    }

    /**
     * @dataProvider getDdlTestData
     * @param RoutineProcedure $procedure
     * @param $doMockSqlMode
     * @param $expectedDDL
     */
    public function testDDL(RoutineProcedure $procedure, $doMockSqlMode, $expectedDDL)
    {
        if ($doMockSqlMode) {
            $mockSqlMode = $this->createMock(SqlMode::class);
            $mockSqlMode->method('getSetStatements')->willReturn('__sql_mode_set__');
            $mockSqlMode->method('getRestoreStatements')->willReturn('__sql_mode_restore__');
            $procedure->setSqlMode($mockSqlMode);
        }

        $this->assertSame($expectedDDL, $procedure->getDDL());
    }

    public function testToStringAliasesGetDDL()
    {
        $ddl = '__ddl__';
        $mockProcedure = $this->getMockBuilder(RoutineProcedure::class)
            ->setConstructorArgs(
                [$this->name]
            )->setMethods(
                ['getDDL']
            )->getMock();
        $mockProcedure->expects($this->once())
            ->method('getDDL')
            ->willReturn($ddl);

        $this->assertSame($ddl, (string)$mockProcedure);
    }

    public function getDdlTestData()
    {
        $databaseName = 'schnoop_db';

        /** @var ProcedureParameterInterface[]|PHPUnit_Framework_MockObject_MockObject[] $mockParameters */
        $mockParameters = [
            $this->createMock(ProcedureParameterInterface::class),
            $this->createMock(ProcedureParameterInterface::class)
        ];

        $mockParameters[0]->method('getDDL')->willReturn('__param_1__');
        $mockParameters[1]->method('getDDL')->willReturn('__param_2__');

        return [
            'Minumal procedure' => [
                $this->createProcedure(
                    $databaseName,
                    '',
                    [],
                    false,
                    HasDelimiterInterface::DEFAULT_DELIMITER,
                    DroppableInterface::DDL_DROP_POLICY_DO_NOT_DROP
                ),
                false,
                <<<SQL
CREATE DEFINER = CURRENT_USER
PROCEDURE `{$this->name}` ()
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY DEFINER
BEGIN
END;
SQL
            ],
            'The works, drop if exists' => [
                $this->createProcedure(
                    $databaseName,
                    'SELECT * FROM table;',
                    $mockParameters,
                    true,
                    '@@',
                    DroppableInterface::DDL_DROP_POLICY_DROP_IF_EXISTS
                ),
                false,
                <<<SQL
DROP PROCEDURE IF EXISTS `{$databaseName}`.`{$this->name}`@@
CREATE DEFINER = CURRENT_USER
PROCEDURE `{$databaseName}`.`{$this->name}` (__param_1__,__param_2__)
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY DEFINER
BEGIN
SELECT * FROM table;
END@@
SQL
            ],
            'Set SQL Mode and drop' => [
                $this->createProcedure(
                    $databaseName,
                    '',
                    [],
                    false,
                    '@@',
                    DroppableInterface::DDL_DROP_POLICY_DROP
                ),
                true,
                <<<SQL
__sql_mode_set__
DROP PROCEDURE `{$this->name}`@@
CREATE DEFINER = CURRENT_USER
PROCEDURE `{$this->name}` ()
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY DEFINER
BEGIN
END@@
__sql_mode_restore__
SQL
            ]
        ];
    }

    /**
     * @expectedException \MilesAsylum\SchnoopSchema\MySQL\Exception\FQNException
     * @expectedExceptionMessage Unable to create DDL with fully-qualified-name because the database name has not been set.
     */
    public function testExceptionOnUseFQNWhenDatabaseNameNotSet()
    {
        $routine = $this->getRoutine();
        $routine->setUseFullyQualifiedName(true);

        $routine->getDDL();
    }

    public function createProcedure(
        $databaseName,
        $body,
        array $parameters,
        $useFullyQualifiedName,
        $delimiter,
        $dropPolicy
    ) {
        $procedure = $this->createRoutine();
        $procedure->setDatabaseName($databaseName);
        $procedure->setBody($body);
        $procedure->setParameters($parameters);
        $procedure->setUseFullyQualifiedName($useFullyQualifiedName);
        $procedure->setDelimiter($delimiter);
        $procedure->setDropPolicy($dropPolicy);

        return $procedure;
    }
}
