<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\Routine\FunctionParameterInterface;
use MilesAsylum\SchnoopSchema\MySQL\Routine\RoutineFunction;
use MilesAsylum\SchnoopSchema\MySQL\Routine\RoutineInterface;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\RoutineTestCase;
use PHPUnit_Framework_MockObject_MockObject;

class FunctionRoutineTest extends RoutineTestCase
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

    public function setUp()
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
        $this->assertSame($this->returns, $this->function->getReturns());
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

    public function testDDL()
    {
        $expectedDDL = <<<SQL
CREATE DEFINER = CURRENT_USER
FUNCTION `schnoop_func` ()
RETURNS _RET_DATATYPE_DDL_
NOT DETERMINISTIC CONTAINS SQL SQL SECURITY DEFINER
BEGIN
END;
SQL;
        $this->assertSame($expectedDDL, (string)$this->function);
    }
}
