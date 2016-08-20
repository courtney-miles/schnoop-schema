<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\AbstractBlobType;
use MilesAsylum\SchnoopSchema\MySQL\DataType\AbstractTextType;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\TextTypeTestCase;
use PHPUnit_Framework_MockObject_MockObject;

class AbstractTextTypeTest extends TextTypeTestCase
{
    /**
     * @var AbstractBlobType
     */
    protected $abstractTextType;

    protected $type = 'foo';

    public function setUp()
    {
        parent::setUp();

        $this->abstractTextType = $this->createMockAbstractTextType($this->type);
    }

    protected function getTextType()
    {
        return $this->abstractTextType;
    }

    protected function createTextType()
    {
        return $this->createMockAbstractTextType($this->type);
    }

    public function testInitialProperties()
    {
        parent::testInitialProperties();
        $this->assertSame($this->type, $this->abstractTextType->getType());
    }

    /**
     * @param string $type
     * @return AbstractTextType|PHPUnit_Framework_MockObject_MockObject
     */
    protected function createMockAbstractTextType($type)
    {
        $abstractTextType = $this->getMockForAbstractClass(AbstractTextType::class);

        $abstractTextType->method('getType')
            ->willReturn($type);

        return $abstractTextType;
    }
}
