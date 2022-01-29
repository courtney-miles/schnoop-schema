<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType\Option;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\QuoteTrait;
use PHPUnit\Framework\TestCase;

class QuoteTraitTest extends TestCase
{
    /**
     * @var QuoteTrait
     */
    protected $quoteTrait;

    public function setUp(): void
    {
        parent::setUp();

        $this->quoteTrait = $this->getMockForTrait(QuoteTrait::class);
    }

    public function testQuoteNumeric(): void
    {
        $this->assertSame('123', $this->quoteTrait->quote(123));
    }

    public function testQuoteString(): void
    {
        $this->assertSame("'Ja\'mie'", $this->quoteTrait->quote("Ja'mie"));
    }
}
