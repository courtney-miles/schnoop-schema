<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\PHPUnit\Framework;

use MilesAsylum\SchnoopSchema\MySQL\DataType\BinaryTypeInterface;

abstract class BinaryTypeTestCase extends DataTypeTestCase
{
    /**
     * @return BinaryTypeInterface
     */
    abstract protected function getBinaryType();

    public function testSetLength(): void
    {
        $binaryType = $this->getBinaryType();

        $binaryType->setLength(3);

        $this->assertTrue($binaryType->hasLength());
        $this->assertSame(3, $binaryType->getLength());
    }

    public function testCast(): void
    {
        $binaryType = $this->getBinaryType();

        $this->assertSame('123', $binaryType->cast(123));
    }
}
