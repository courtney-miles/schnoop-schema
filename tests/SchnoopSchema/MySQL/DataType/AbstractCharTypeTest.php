<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\AbstractCharType;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\CharTypeTestCase;
use PHPUnit_Framework_MockObject_MockObject;

class AbstractCharTypeTest extends CharTypeTestCase
{
    /**
     * @var AbstractCharType
     */
    protected $abstractCharType;

    protected $type = 'foo';

    protected $length = 6;

    public function setUp()
    {
        parent::setUp();

        $this->abstractCharType = $this->createMockAbstractCharType($this->type);
    }

    protected function getCharType()
    {
        return $this->abstractCharType;
    }

    protected function createCharType()
    {
        return $this->createMockAbstractCharType($this->type);
    }

    protected function getInitialLength()
    {
        return $this->length;
    }

    public function testInitialProperties()
    {
        parent::testInitialProperties();
        $this->assertSame($this->type, $this->abstractCharType->getType());
    }

    /**
     * @param $type
     * @return AbstractCharType|PHPUnit_Framework_MockObject_MockObject
     */
    protected function createMockAbstractCharType($type)
    {
        $abstractStringType = $this->getMockForAbstractClass(
            AbstractCharType::class,
            [$this->length]
        );

        $abstractStringType->method('getType')
            ->willReturn($type);

        return $abstractStringType;
    }
}
