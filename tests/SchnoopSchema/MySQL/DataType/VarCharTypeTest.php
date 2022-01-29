<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\VarCharType;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\CharTypeTestCase;

class VarCharTypeTest extends CharTypeTestCase
{
    /**
     * @var VarCharType
     */
    protected $varCharType;
    protected $length = 6;

    public function setUp(): void
    {
        parent::setUp();

        $this->varCharType = new VarCharType($this->length);
    }

    protected function getCharType()
    {
        return $this->varCharType;
    }

    protected function createCharType()
    {
        return new VarCharType($this->length);
    }

    protected function getInitialLength()
    {
        return $this->length;
    }

    public function testInitialProperties(): void
    {
        parent::testInitialProperties();
        $this->assertSame(DataTypeInterface::TYPE_VARCHAR, $this->varCharType->getType());
    }
}
