<?php

namespace MilesAsylum\SchnoopSchema\PHPUnit\Framework;

use MilesAsylum\SchnoopSchema\MySQL\DataType\NumericPointTypeInterface;

abstract class NumericPointTypeTestCase extends DataTypeTestCase
{
    /**
     * @return NumericPointTypeInterface
     */
    abstract protected function getNumericPointType();

    /**
     * @return NumericPointTypeInterface
     */
    abstract protected function createNumericPointType();

    public function testInitialProperties()
    {
        $numericPointType = $this->getNumericPointType();

        $this->assertTrue($numericPointType->isSigned());
        $this->assertFalse($numericPointType->hasPrecision());
        $this->assertNull($numericPointType->getPrecision());
        $this->assertFalse($numericPointType->hasScale());
        $this->assertNull($numericPointType->getScale());
        $this->assertNull($numericPointType->getMinRange());
        $this->assertNull($numericPointType->getMaxRange());
        $this->assertTrue($numericPointType->doesAllowDefault());
        $this->assertFalse($numericPointType->isZeroFill());
    }

    public function testSetSigned()
    {
        $numericPointType = $this->getNumericPointType();
        $numericPointType->setSigned(false);

        $this->assertFalse($numericPointType->isSigned());
    }

    public function testSetPrecision()
    {
        $numericPointType = $this->getNumericPointType();

        $precision = 6;
        $numericPointType->setPrecisionScale($precision);

        $this->assertTrue($numericPointType->hasPrecision());
        $this->assertSame($precision, $numericPointType->getPrecision());

        $this->assertFalse($numericPointType->hasScale());
        $this->assertSame(0, $numericPointType->getScale());
    }

    public function testSetPrecisionScale()
    {
        $numericPointType = $this->getNumericPointType();

        $precision = 6;
        $scale = 4;

        $numericPointType->setPrecisionScale($precision, $scale);

        $this->assertTrue($numericPointType->hasPrecision());
        $this->assertSame($precision, $numericPointType->getPrecision());

        $this->assertTrue($numericPointType->hasScale());
        $this->assertSame($scale, $numericPointType->getScale());
    }

    public function testSetZeroFill()
    {
        $numericPointType = $this->getNumericPointType();
        $numericPointType->setZeroFill(true);

        $this->assertTrue($numericPointType->isZeroFill());
    }

    public function testMinRangeSigned()
    {
        $numericPointType = $this->getNumericPointType();
        $numericPointType->setPrecisionScale(6, 2);

        $this->assertSame('-9999.99', $numericPointType->getMinRange());
    }

    public function testMinRangeUnsigned()
    {
        $numericPointType = $this->getNumericPointType();
        $numericPointType->setPrecisionScale(6, 2);
        $numericPointType->setSigned(false);

        $this->assertSame(0, $numericPointType->getMinRange());
    }

    public function testMaxRange()
    {
        $numericPointType = $this->getNumericPointType();
        $numericPointType->setPrecisionScale(6, 2);

        $this->assertSame('9999.99', $numericPointType->getMaxRange());
    }

    public function DDLProvider()
    {
        $numericPointType = $this->createNumericPointType();

        $numericPointTypeUnsigned = $this->createNumericPointType();
        $numericPointTypeUnsigned->setSigned(false);

        $numericPointTypePrecision = $this->createNumericPointType();
        $numericPointTypePrecision->setPrecisionScale(6);

        $numericPointTypePrecisionScale = $this->createNumericPointType();
        $numericPointTypePrecisionScale->setPrecisionScale(6, 2);

        $numericPointTypeUnsignedPrecisionScale = $this->createNumericPointType();
        $numericPointTypeUnsignedPrecisionScale->setSigned(false);
        $numericPointTypeUnsignedPrecisionScale->setPrecisionScale(6, 2);

        return [
            [
                strtoupper($numericPointType->getType()),
                $numericPointType
            ],
            [
                strtoupper($numericPointTypeUnsigned->getType()) . ' UNSIGNED',
                $numericPointTypeUnsigned
            ],
            [
                strtoupper($numericPointTypePrecision->getType()) . '(6)',
                $numericPointTypePrecision
            ],
            [
                strtoupper($numericPointTypePrecisionScale->getType()) . '(6,2)',
                $numericPointTypePrecisionScale
            ],
            [
                strtoupper($numericPointTypeUnsignedPrecisionScale->getType()) . '(6,2) UNSIGNED',
                $numericPointTypeUnsignedPrecisionScale
            ]
        ];
    }
}
