<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\SmallIntType;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\IntTypeTestCase;

class SmallIntTypeTest extends IntTypeTestCase
{
    /**
     * @var SmallIntType
     */
    protected $smallIntType;

    public function setUp(): void
    {
        parent::setUp();

        $this->smallIntType = new SmallIntType();
    }

    protected function getIntType()
    {
        return $this->smallIntType;
    }

    public function testInitialProperties(): void
    {
        parent::testInitialProperties();
        $this->assertSame(DataTypeInterface::TYPE_SMALLINT, $this->smallIntType->getType());
        $this->assertSame(SmallIntType::MIN_SIGNED, $this->smallIntType->getMinRange());
        $this->assertSame(SmallIntType::MAX_SIGNED, $this->smallIntType->getMaxRange());
    }

    public function testSetUnsigned(): void
    {
        $this->smallIntType->setSigned(false);

        $this->assertFalse($this->smallIntType->isSigned());
        $this->assertSame(SmallIntType::MIN_UNSIGNED, $this->smallIntType->getMinRange());
        $this->assertSame(SmallIntType::MAX_UNSIGNED, $this->smallIntType->getMaxRange());
    }

    /**
     * @see testDDL
     *
     * @return array
     */
    public function DDLProvider()
    {
        $tinyIntTypeDefault = new SmallIntType();

        $tinyIntTypeExtra = new SmallIntType();
        $tinyIntTypeExtra->setDisplayWidth(3);
        $tinyIntTypeExtra->setSigned(false);

        return [
            [
                'SMALLINT',
                $tinyIntTypeDefault,
            ],
            [
                'SMALLINT(3) UNSIGNED',
                $tinyIntTypeExtra,
            ],
        ];
    }
}
