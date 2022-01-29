<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\PHPUnit\Framework;

use MilesAsylum\SchnoopSchema\MySQL\DataType\IntTypeInterface;

abstract class IntTypeTestCase extends DataTypeTestCase
{
    /**
     * @return IntTypeInterface
     */
    abstract protected function getIntType();

    public function testInitialProperties(): void
    {
        $intType = $this->getIntType();

        $this->assertFalse($intType->hasDisplayWidth());
        $this->assertNull($intType->getDisplayWidth());
        $this->assertTrue($intType->isSigned());
        $this->assertTrue($intType->doesAllowDefault());
        $this->assertFalse($intType->isZeroFill());
    }

    public function testSetDisplayWidth(): void
    {
        $displayWidth = 2;
        $intType = $this->getIntType();
        $intType->setDisplayWidth($displayWidth);

        $this->assertTrue($intType->hasDisplayWidth());
        $this->assertSame($displayWidth, $intType->getDisplayWidth());
    }

    public function testZeroFill(): void
    {
        $intType = $this->getIntType();
        $intType->setZeroFill(true);

        $this->assertTrue($intType->isZeroFill());
    }

    public function testCast(): void
    {
        $intType = $this->getIntType();

        $this->assertSame(123, $intType->cast('123'));
    }
}
