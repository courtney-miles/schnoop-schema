<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\AbstractTimeType;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\TimeTypeTestCase;

class AbstractTimeTypeTest extends TimeTypeTestCase
{
    protected $abstractTimeType;

    protected $type = 'foo';

    public function setUp(): void
    {
        parent::setUp();

        $this->abstractTimeType = $this->createMockAbstractTimeType($this->type);
    }

    protected function getTimeType()
    {
        return $this->abstractTimeType;
    }

    protected function createTimeType()
    {
        return $this->createMockAbstractTimeType($this->type);
    }

    /**
     * @param $type
     * @return AbstractTimeType|PHPUnit_Framework_MockObject_MockObject
     */
    protected function createMockAbstractTimeType($type)
    {
        $abstractTimeType = $this->getMockForAbstractClass(AbstractTimeType::class);
        $abstractTimeType->method('getType')->willReturn($type);

        return $abstractTimeType;
    }
}
