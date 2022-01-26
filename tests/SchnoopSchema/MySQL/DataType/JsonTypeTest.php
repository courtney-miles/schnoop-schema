<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\DataType\JsonType;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\DataTypeTestCase;

/**
 * @covers \MilesAsylum\SchnoopSchema\MySQL\DataType\JsonType
 */
class JsonTypeTest extends DataTypeTestCase
{
    public function testInitialProperties(): void
    {
        $sut = new JsonType();

        self::assertSame(DataTypeInterface::TYPE_JSON, $sut->getType());
        self::assertTrue($sut->doesAllowDefault());
    }

    public function testCast(): void
    {
        $sut = new JsonType();

        self::assertSame('[123]', $sut->cast([123]));
    }

    public function DDLProvider()
    {
        return [
            ['JSON', new JsonType()]
        ];
    }
}
