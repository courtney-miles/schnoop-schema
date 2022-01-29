<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\BigIntType;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\IntTypeTestCase;

class BigIntTypeTest extends IntTypeTestCase
{
    /**
     * @var BigIntType
     */
    protected $bigIntType;

    public function setUp(): void
    {
        parent::setUp();

        $this->bigIntType = new BigIntType();
    }

    protected function getIntType()
    {
        return $this->bigIntType;
    }

    protected function newIntType()
    {
        return new BigIntType();
    }

    public function testInitialProperties(): void
    {
        parent::testInitialProperties();
        $this->assertSame(DataTypeInterface::TYPE_BIGINT, $this->bigIntType->getType());
        $this->assertSame(BigIntType::MIN_SIGNED, $this->bigIntType->getMinRange());
        $this->assertSame(BigIntType::MAX_SIGNED, $this->bigIntType->getMaxRange());
    }

    public function testSetUnsigned(): void
    {
        $this->bigIntType->setSigned(false);

        $this->assertFalse($this->bigIntType->isSigned());
        $this->assertSame(BigIntType::MIN_UNSIGNED, $this->bigIntType->getMinRange());
        $this->assertSame(BigIntType::MAX_UNSIGNED, $this->bigIntType->getMaxRange());
    }

    /**
     * @see testDDL
     *
     * @return array
     */
    public function DDLProvider()
    {
        $bigIntTypeDefault = new BigIntType();

        $BigIntTypeExtra = new BigIntType();
        $BigIntTypeExtra->setDisplayWidth(3);
        $BigIntTypeExtra->setSigned(false);

        return [
            [
                'BIGINT',
                $bigIntTypeDefault,
            ],
            [
                'BIGINT(3) UNSIGNED',
                $BigIntTypeExtra,
            ],
        ];
    }
}
