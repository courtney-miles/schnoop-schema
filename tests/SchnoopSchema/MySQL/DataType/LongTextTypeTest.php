<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\LongTextType;
use MilesAsylum\SchnoopSchema\MySQL\DataType\TextTypeInterface;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\TextTypeTestCase;

class LongTextTypeTest extends TextTypeTestCase
{
    /**
     * @var LongTextType
     */
    protected $longTextType;

    public function setUp(): void
    {
        parent::setUp();

        $this->longTextType = new LongTextType();
    }

    /**
     * @return TextTypeInterface
     */
    protected function getTextType()
    {
        return $this->longTextType;
    }

    /**
     * @return TextTypeInterface
     */
    protected function createTextType()
    {
        return new LongTextType();
    }

    public function testInitialProperties(): void
    {
        parent::testInitialProperties();
        $this->assertSame(DataTypeInterface::TYPE_LONGTEXT, $this->longTextType->getType());
        $this->assertSame(4294967295, $this->longTextType->getLength());
    }
}
