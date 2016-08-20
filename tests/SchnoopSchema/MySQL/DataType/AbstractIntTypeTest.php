<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\IntTypeTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\AbstractIntType;
use PHPUnit_Framework_MockObject_MockObject;

class AbstractIntTypeTest extends IntTypeTestCase
{
    /**
     * @var AbstractIntType
     */
    protected $abstractIntType;

    protected $type = 'foo';

    public function setUp()
    {
        parent::setUp();

        $this->abstractIntType = $this->createMockAbstractIntType($this->type);
    }

    protected function getIntType()
    {
        return $this->abstractIntType;
    }

    public function testSetUnsigned()
    {
        $this->abstractIntType->setSigned(false);

        $this->assertFalse($this->abstractIntType->isSigned());
    }

    /**
     * @see testDDL
     * @return array
     */
    public function DDLProvider()
    {
        $abstractIntType = $this->createMockAbstractIntType('foo');

        $abstractIntTypeExtra = $this->createMockAbstractIntType('foo');
        $abstractIntTypeExtra->setSigned(false);
        $abstractIntTypeExtra->setDisplayWidth(3);

        return [
            [
                'FOO',
                $abstractIntType
            ],
            [
                'FOO(3) UNSIGNED',
                $abstractIntTypeExtra
            ]
        ];
    }

    /**
     * @param string $type
     * @return AbstractIntType|PHPUnit_Framework_MockObject_MockObject
     */
    protected function createMockAbstractIntType($type)
    {
        $abstractIntType = $this->getMockForAbstractClass(
            AbstractIntType::class
        );
        $abstractIntType->method('getType')
            ->willReturn($type);

        return $abstractIntType;
    }
}
