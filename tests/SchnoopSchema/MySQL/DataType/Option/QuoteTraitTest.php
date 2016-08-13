<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\DataType\Option;

use MilesAsylum\SchnoopSchema\MySQL\DataType\Option\QuoteTrait;

class QuoteTraitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var QuoteTrait
     */
    protected $quoteTrait;

    public function setUp()
    {
        parent::setUp();

        $this->quoteTrait = $this->getMockForTrait(QuoteTrait::class);
    }

    public function testQuoteNumeric()
    {
        $this->assertSame('123', $this->quoteTrait->quote(123));
    }

    public function testQuoteString()
    {
        $this->assertSame("'Ja\'mie'", $this->quoteTrait->quote("Ja'mie"));
    }
}
