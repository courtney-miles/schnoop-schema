<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DroppableInterface;
use MilesAsylum\SchnoopSchema\MySQL\Exception\FQNException;
use MilesAsylum\SchnoopSchema\MySQL\HasDelimiterInterface;
use MilesAsylum\SchnoopSchema\MySQL\MySQLInterface;
use MilesAsylum\SchnoopSchema\MySQL\Routine\FunctionParameterInterface;
use MilesAsylum\SchnoopSchema\MySQL\Routine\ProcedureParameterInterface;
use MilesAsylum\SchnoopSchema\MySQL\Routine\RoutineFunction;
use MilesAsylum\SchnoopSchema\MySQL\Routine\RoutineInterface;
use MilesAsylum\SchnoopSchema\MySQL\SetVar\SqlMode;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\RoutineTestCase;
use PHPUnit_Framework_MockObject_MockObject;

class RoutineFunctionTest extends RoutineTestCase
{
    protected $name = 'schnoop_func';

    /**
     * @var DataTypeInterface
     */
    protected $returns;

    /**
     * @var RoutineFunction
     */
    protected $function;

    public function setUp(): void
    {
        parent::setUp();

        $this->returns = $this->createMock(DataTypeInterface::class);
        $this->returns->method('__toString')
            ->willReturn('_RET_DATATYPE_DDL_');

        $this->function = $this->createRoutine();
    }

    /**
     * @return RoutineInterface
     */
    protected function getRoutine()
    {
        return $this->function;
    }

    /**
     * @return RoutineInterface
     */
    protected function createRoutine()
    {
        return new RoutineFunction($this->name, $this->returns);
    }

    protected function getExpectedName()
    {
        return $this->name;
    }

    public function testInitialProperties()
    {
        parent::testInitialProperties();

        $this->assertFalse($this->function->hasParameters());
        $this->assertSame([], $this->function->getParameters());
        $this->assertSame($this->returns, $this->function->getReturnType());
    }

    public function testSetReturns()
    {
        $mockReturns = $this->createMock(DataTypeInterface::class);

        $this->function->setReturnType($mockReturns);

        $this->assertSame($mockReturns, $this->function->getReturnType());
    }

    public function testSetParameters()
    {
        /** @var FunctionParameterInterface[]|PHPUnit_Framework_MockObject_MockObject[] $parameters */
        $parameters = [
            $this->createMock(FunctionParameterInterface::class),
            $this->createMock(FunctionParameterInterface::class)
        ];

        $parameters[0]->method('getName')
            ->willReturn('param_1');
        $parameters[0]->method('getName')
            ->willReturn('param_2');

        $this->function->setParameters($parameters);

        $this->assertTrue($this->function->hasParameters());
        $this->assertSame($parameters, $this->function->getParameters());
    }

    public function testAddParameter()
    {
        /** @var FunctionParameterInterface[]|PHPUnit_Framework_MockObject_MockObject[] $parameters */
        $parameters = [
            $this->createMock(FunctionParameterInterface::class),
            $this->createMock(FunctionParameterInterface::class)
        ];

        $parameters[0]->method('getName')
            ->willReturn('param_1');
        $parameters[0]->method('getName')
            ->willReturn('param_2');

        $this->function->setParameters([$parameters[0]]);
        $this->function->addParameter($parameters[1]);

        $this->assertSame($parameters, $this->function->getParameters());
    }

    /**
     * @dataProvider getDDLTestData
     * @param RoutineFunction $function
     * @param bool $doMockSqlMode
     * @param $expectedDDL
     */
    public function testGetDDL(RoutineFunction $function, $doMockSqlMode, $expectedDDL)
    {
        if ($doMockSqlMode) {
            $mockSqlMode = $this->createMock(SqlMode::class);
            $mockSqlMode->method('getSetStatements')->willReturn('__sql_mode_set__');
            $mockSqlMode->method('getRestoreStatements')->willReturn('__sql_mode_restore__');
            $function->setSqlMode($mockSqlMode);
        }

        $this->assertSame($expectedDDL, $function->getCreateStatement());
    }

    public function testToStringAliasesGetDDL()
    {
        $ddl = '__ddl__';
        $mockFunction = $this->getMockBuilder(RoutineFunction::class)
            ->setConstructorArgs(
                [$this->name, $this->returns]
            )->setMethods(
                ['getCreateStatement']
            )->getMock();
        $mockFunction->expects($this->once())
            ->method('getCreateStatement')
            ->willReturn($ddl);

        $this->assertSame($ddl, (string)$mockFunction);
    }

    /**
     * @see testGetDDL
     * @return array
     */
    public function getDDLTestData()
    {
        $name = 'schnoop_func';
        $databaseName = 'schnoop_db';

        $mockReturnType = $this->createMock(DataTypeInterface::class);
        $mockReturnType->method('getDDL')
            ->willReturn('__return_ddl__');

        $mockParameters = [
            $this->createMock(ProcedureParameterInterface::class),
            $this->createMock(ProcedureParameterInterface::class)
        ];

        $mockParameters[0]->method('getDDL')->willReturn('__param_1__');
        $mockParameters[1]->method('getDDL')->willReturn('__param_2__');

        return [
            'Minimal function' => [
                $this->createFunction(
                    $name,
                    $databaseName,
                    $mockReturnType,
                    '',
                    [],
                    false,
                    HasDelimiterInterface::DEFAULT_DELIMITER,
                    DroppableInterface::DDL_DROP_POLICY_DO_NOT_DROP
                ),
                false,
                <<<SQL
CREATE DEFINER = CURRENT_USER
FUNCTION `{$name}` ()
RETURNS __return_ddl__
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY DEFINER
BEGIN
END;
SQL
            ],
            'The works, drop if exists' => [
                $this->createFunction(
                    $name,
                    $databaseName,
                    $mockReturnType,
                    'SELECT * FROM `schnoop_tbl`;',
                    $mockParameters,
                    true,
                    '@@',
                    DroppableInterface::DDL_DROP_POLICY_DROP_IF_EXISTS
                ),
                false,
                <<<SQL
DROP FUNCTION IF EXISTS `{$databaseName}`.`{$name}`@@
CREATE DEFINER = CURRENT_USER
FUNCTION `{$databaseName}`.`{$name}` (
  __param_1__,
  __param_2__
)
RETURNS __return_ddl__
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY DEFINER
BEGIN
SELECT * FROM `schnoop_tbl`;
END@@
SQL
            ],
            'Set SQL mode and drop' => [
                $this->createFunction(
                    $name,
                    $databaseName,
                    $mockReturnType,
                    '',
                    [],
                    false,
                    '@@',
                    DroppableInterface::DDL_DROP_POLICY_DROP
                ),
                true,
                <<<SQL
__sql_mode_set__
DROP FUNCTION `{$name}`@@
CREATE DEFINER = CURRENT_USER
FUNCTION `{$name}` ()
RETURNS __return_ddl__
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY DEFINER
BEGIN
END@@
__sql_mode_restore__
SQL
            ]
        ];
    }

    public function testExceptionOnUseFQNWhenDatabaseNameNotSet()
    {
        $this->expectExceptionMessage(
            'Unable to create DDL with fully-qualified-name because the database name has not been set.'
        );
        $this->expectException(FQNException::class);
        $routine = $this->getRoutine();
        $routine->setUseFullyQualifiedName(true);

        $routine->getCreateStatement();
    }

    /**
     * @param $name
     * @param $databaseName
     * @param DataTypeInterface $returnType
     * @param $body
     * @param ProcedureParameterInterface[] $parameters
     * @param $useFQN
     * @param $ddlDelimiter
     * @param $ddlDropPolicy
     * @return RoutineFunction
     */
    protected function createFunction(
        $name,
        $databaseName,
        DataTypeInterface $returnType,
        $body,
        array $parameters,
        $useFQN,
        $ddlDelimiter,
        $ddlDropPolicy
    ) {
        $function = new RoutineFunction($name, $returnType);
        $function->setDatabaseName($databaseName);
        $function->setBody($body);
        $function->setParameters($parameters);
        $function->setUseFullyQualifiedName($useFQN);
        $function->setDelimiter($ddlDelimiter);
        $function->setDropPolicy($ddlDropPolicy);

        return $function;
    }
}
