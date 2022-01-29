<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\MediumIntType;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\IntTypeTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;

class MediumIntTypeTest extends IntTypeTestCase
{
    /**
     * @var MediumIntType
     */
    protected $mediumIntType;

    public function setUp(): void
    {
        parent::setUp();

        $this->mediumIntType = new MediumIntType();
    }

    protected function getIntType()
    {
        return $this->mediumIntType;
    }

    public function testInitialProperties()
    {
        parent::testInitialProperties();
        $this->assertSame(DataTypeInterface::TYPE_MEDIUMINT, $this->mediumIntType->getType());
        $this->assertSame(MediumIntType::MIN_SIGNED, $this->mediumIntType->getMinRange());
        $this->assertSame(MediumIntType::MAX_SIGNED, $this->mediumIntType->getMaxRange());
    }

    public function testSetUnsigned()
    {
        $this->mediumIntType->setSigned(false);

        $this->assertFalse($this->mediumIntType->isSigned());
        $this->assertSame(MediumIntType::MIN_UNSIGNED, $this->mediumIntType->getMinRange());
        $this->assertSame(MediumIntType::MAX_UNSIGNED, $this->mediumIntType->getMaxRange());
    }

    /**
     * @see testDDL
     * @return array
     */
    public function DDLProvider()
    {
        $intTypeDefault = new MediumIntType();

        $intTypeExtra = new MediumIntType();
        $intTypeExtra->setDisplayWidth(3);
        $intTypeExtra->setSigned(false);

        return [
            [
                'MEDIUMINT',
                $intTypeDefault
            ],
            [
                'MEDIUMINT(3) UNSIGNED',
                $intTypeExtra
            ]
        ];
    }
}
