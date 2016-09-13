<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\Routine\FunctionParameter;
use MilesAsylum\SchnoopSchema\MySQL\Routine\RoutineParameterInterface;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\RoutineParameterTestCase;

class FunctionParameterTest extends RoutineParameterTestCase
{
    protected $name = 'param_name';

    /**
     * @var DataTypeInterface
     */
    protected $mockDataType;

    /**
     * @var FunctionParameter
     */
    protected $functionParameter;

    public function setUp()
    {
        parent::setUp();

        $this->mockDataType = $this->createMock(DataTypeInterface::class);
        $this->mockDataType->method('__toString')
            ->willReturn('DT_DDL');

        $this->functionParameter = new FunctionParameter($this->name, $this->mockDataType);
    }

    /**
     * @return RoutineParameterInterface
     */
    protected function getRoutineParameter()
    {
        return $this->functionParameter;
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

        $this->assertSame(FunctionParameter::DIRECTION_IN, $this->functionParameter->getDirection());
    }

    public function testDDL()
    {
        $this->assertSame("IN `param_name` DT_DDL", (string)$this->functionParameter);
    }
}
