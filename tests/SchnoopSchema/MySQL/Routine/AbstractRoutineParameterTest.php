<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\Routine\AbstractRoutineParameter;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\RoutineParameterTestCase;

class AbstractRoutineParameterTest extends RoutineParameterTestCase
{
    protected $name = 'param_name';

    /**
     * @var DataTypeInterface
     */
    protected $mockDataType;

    /**
     * @var AbstractRoutineParameter
     */
    protected $abstractRoutineParameter;

    public function setUp(): void
    {
        parent::setUp();

        $this->mockDataType = $this->createMock(DataTypeInterface::class);

        $this->abstractRoutineParameter = $this->getMockForAbstractClass(
            AbstractRoutineParameter::class,
            [$this->name, $this->mockDataType]
        );
    }

    protected function getRoutineParameter()
    {
        return $this->abstractRoutineParameter;
    }

    protected function getExpectedParameterName()
    {
        return $this->name;
    }

    protected function getExpectedParameterDataType()
    {
        return $this->mockDataType;
    }
}
