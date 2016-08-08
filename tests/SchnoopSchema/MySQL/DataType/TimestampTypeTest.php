<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\TimestampType;

class TimestampTypeTest extends SchnoopTestCase
{
    /**
     * @dataProvider timeTypeProvider
     * @param int $expectedPrecision
     * @param string $expectedDDL
     * @param TimestampType $actualTimestampType
     */
    public function testConstruct(
        $expectedPrecision,
        $expectedDDL,
        TimestampType $actualTimestampType
    ) {
        $this->timeTypeAsserts(
            DataTypeInterface::TYPE_TIMESTAMP,
            $expectedPrecision,
            true,
            $expectedDDL,
            $actualTimestampType
        );
    }

    /**
     * @see testConstruct
     */
    public function timeTypeProvider()
    {
        $precision = 3;

        return [
            [
                0,
                'TIMESTAMP',
                new TimestampType()
            ],
            [
                $precision,
                "TIMESTAMP($precision)",
                new TimestampType($precision)
            ]
        ];
    }
}
