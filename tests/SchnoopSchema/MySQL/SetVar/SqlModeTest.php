<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\SetVar;

use MilesAsylum\SchnoopSchema\MySQL\SetVar\SqlMode;
use PHPUnit\Framework\TestCase;

class SqlModeTest extends TestCase
{
    /**
     * @var SqlMode
     */
    protected $sqlMode;
    protected $mode = 'FOO';

    public function setUp()
    {
        parent::setUp();

        $this->sqlMode = new SqlMode($this->mode);
    }

    public function testInitialProperties()
    {
        $this->assertSame($this->mode, $this->sqlMode->getMode());
    }

    public function testSetMode()
    {
        $newMode = 'BAR';
        $this->sqlMode->setMode($newMode);

        $this->assertSame($newMode, $this->sqlMode->getMode());
    }
}
