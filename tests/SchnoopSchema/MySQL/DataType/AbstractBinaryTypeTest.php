<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 28/06/16
 * Time: 8:09 PM
 */

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\PHPUnit\Framework\SchnoopTestCase;
use MilesAsylum\SchnoopSchema\MySQL\DataType\AbstractBinaryType;

class AbstractBinaryTypeTest extends SchnoopTestCase
{
    /**
     * @var AbstractBinaryType
     */
    protected $abstractBinaryType;

    protected $length = '3';

    protected $type = 'foo';

    public function setUp()
    {
        parent::setUp();

        $this->abstractBinaryType = $this->getMockForAbstractClass(
            AbstractBinaryType::class,
            [
                $this->length
            ]
        );

        $this->abstractBinaryType->method('getType')
            ->willReturn($this->type);
    }

    public function testConstructed()
    {
        $this->binaryTypeAsserts(
            $this->type,
            (int)$this->length,
            null,
            'FOO(' . $this->length . ')',
            $this->abstractBinaryType
        );
    }

    public function testCast()
    {
        $this->assertSame('123', $this->abstractBinaryType->cast(123));
    }
}
