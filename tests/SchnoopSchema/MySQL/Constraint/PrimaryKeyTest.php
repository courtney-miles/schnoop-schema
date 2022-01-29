<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\Constraint\PrimaryKey;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopSchemaTestCase;

class PrimaryKeyTest extends SchnoopSchemaTestCase
{
    public function testInitialProperties(): void
    {
        $primaryKey = new PrimaryKey();

        $this->assertSame('primary', $primaryKey->getName());
    }
}
