<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\SetVar;

use MilesAsylum\SchnoopSchema\MySQL\HasDelimiterInterface;
use MilesAsylum\SchnoopSchema\MySQL\SetVar\SqlMode;
use PHPUnit\Framework\TestCase;

class SqlModeTest extends TestCase
{
    /**
     * @var SqlMode
     */
    protected $sqlMode;
    protected $mode = 'FOO';

    public function setUp(): void
    {
        parent::setUp();

        $this->sqlMode = new SqlMode($this->mode);
    }

    public function testInitialProperties(): void
    {
        $this->assertSame($this->mode, $this->sqlMode->getMode());
        $this->assertSame(HasDelimiterInterface::DEFAULT_DELIMITER, $this->sqlMode->getDelimiter());
    }

    public function testSetMode(): void
    {
        $newMode = 'BAR';
        $this->sqlMode->setMode($newMode);

        $this->assertSame($newMode, $this->sqlMode->getMode());
    }

    public function testSetDelimiter(): void
    {
        $delimiter = '@@';
        $this->sqlMode->setDelimiter($delimiter);

        $this->assertSame($delimiter, $this->sqlMode->getDelimiter());
    }

    public function testGetSetStatements(): void
    {
        $expectedStatements = <<<SQL
SET @_schnoop_sql_mode = @@session.sql_mode;
SET @@session.sql_mode = '{$this->mode}';
SQL;

        $this->assertSame($expectedStatements, $this->sqlMode->getSetStatements());
    }

    public function testGetRestoreStatements(): void
    {
        $expectedStatements = <<<SQL
SET @@session.sql_mode = @_schnoop_sql_mode;
SET @_schnoop_sql_mode = NULL;
SQL;

        $this->assertSame($expectedStatements, $this->sqlMode->getRestoreStatements());
    }
}
