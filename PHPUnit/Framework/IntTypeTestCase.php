<?php

namespace MilesAsylum\SchnoopSchema\PHPUnit\Framework;

use MilesAsylum\SchnoopSchema\MySQL\DataType\IntTypeInterface;

abstract class IntTypeTestCase extends DataTypeTestCase
{
    /**
     * @return IntTypeInterface
     */
    abstract protected function getIntType();

    public function testInitialProperties()
    {
        $intType = $this->getIntType();

        $this->assertFalse($intType->hasDisplayWidth());
        $this->assertNull($intType->getDisplayWidth());

        $this->assertTrue($intType->isSigned());

        $this->assertTrue($intType->doesAllowDefault());
    }

    public function testDisplayWidth()
    {
        $displayWidth = 2;
        $intType = $this->getIntType();
        $intType->setDisplayWidth($displayWidth);

        $this->assertTrue($intType->hasDisplayWidth());
        $this->assertSame($displayWidth, $intType->getDisplayWidth());
    }

    public function testCast()
    {
        $intType = $this->getIntType();

        $this->assertSame(123, $intType->cast('123'));
    }
}
