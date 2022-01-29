<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\TextTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\MediumTextType;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\TextTypeTestCase;

class MediumTextTypeTest extends TextTypeTestCase
{
    /**
     * @var MediumTextType
     */
    protected $mediumTextType;

    public function setUp(): void
    {
        parent::setUp();

        $this->mediumTextType = new MediumTextType();
    }

    /**
     * @return TextTypeInterface
     */
    protected function getTextType()
    {
        return $this->mediumTextType;
    }

    /**
     * @return TextTypeInterface
     */
    protected function createTextType()
    {
        return new MediumTextType();
    }

    public function testInitialProperties()
    {
        parent::testInitialProperties();
        $this->assertSame(DataTypeInterface::TYPE_MEDIUMTEXT, $this->mediumTextType->getType());
        $this->assertSame(16777215, $this->mediumTextType->getLength());
    }
}
