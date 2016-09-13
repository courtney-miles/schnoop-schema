<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\Routine\ProcedureParameterInterface;
use MilesAsylum\SchnoopSchema\MySQL\Routine\ProcedureRoutine;
use MilesAsylum\SchnoopSchema\MySQL\Routine\RoutineInterface;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\RoutineTestCase;
use PHPUnit_Framework_MockObject_MockObject;

class ProcedureRoutineTest extends RoutineTestCase
{
    protected $name = 'schnoop_proc';

    /**
     * @var ProcedureRoutine
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
     * @return RoutineInterface
     */
    protected function createRoutine()
    {
        return new ProcedureRoutine($this->name);
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

    public function testDDL()
    {
        $expectedDDL = <<<SQL
CREATE DEFINER = CURRENT_USER
PROCEDURE `schnoop_proc` ()
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY DEFINER
BEGIN
END
SQL;
        $this->assertSame($expectedDDL, (string)$this->procedure);
    }
}
