<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\Routine\ProcedureParameter;
use MilesAsylum\SchnoopSchema\MySQL\Routine\ProcedureParameterInterface;
use MilesAsylum\SchnoopSchema\MySQL\Routine\RoutineParameterInterface;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\RoutineParameterTestCase;

class ProcedureParameterTest extends RoutineParameterTestCase
{
    protected $name = 'param_name';

    /**
     * @var DataTypeInterface
     */
    protected $mockDataType;

    /**
     * @var ProcedureParameter
     */
    protected $procedureParameter;

    public function setUp()
    {
        parent::setUp();

        $this->mockDataType = $this->createMock(DataTypeInterface::class);
        $this->mockDataType->method('__toString')
            ->willReturn('DT_DDL');

        $this->procedureParameter = new ProcedureParameter($this->name, $this->mockDataType);
    }

    /**
     * @return RoutineParameterInterface
     */
    protected function getRoutineParameter()
    {
        return $this->procedureParameter;
    }

    protected function getExpectedParameterName()
    {
        return $this->name;
    }

    /**
     * @return DataTypeInterface
     */
    protected function getExpectedParameterDataType()
    {
        return $this->mockDataType;
    }

    public function testInitialProperties()
    {
        parent::testInitialProperties();

        $this->assertSame(ProcedureParameterInterface::DIRECTION_IN, $this->procedureParameter->getDirection());
    }

    public function testSetDirection()
    {
        $this->procedureParameter->setDirection(ProcedureParameterInterface::DIRECTION_INOUT);

        $this->assertSame(ProcedureParameterInterface::DIRECTION_INOUT, $this->procedureParameter->getDirection());
    }

    public function testDDL()
    {
        $this->assertSame("IN `param_name` DT_DDL", (string)$this->procedureParameter);
    }
}
