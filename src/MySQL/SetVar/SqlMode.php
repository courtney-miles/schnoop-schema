<?php

namespace MilesAsylum\SchnoopSchema\MySQL\SetVar;

use MilesAsylum\SchnoopSchema\MySQL\HasDelimiterInterface;
use MilesAsylum\SchnoopSchema\MySQL\MySQLInterface;

class SqlMode implements MySQLInterface, HasDelimiterInterface
{
    protected $mode;

    protected $delimiter = self::DEFAULT_DELIMITER;

    /**
     * SqlMode constructor.
     * @param string $mode SQL Mode
     */
    public function __construct($mode)
    {
        $this->mode = $mode;
    }

    /**
     * Get the SQL mode.
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Set the SQL mode.
     * @param mixed $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    /**
     * Get the delimiter to use between statements.
     * @return string
     */
    public function getDelimiter()
    {
        return $this->delimiter;
    }

    /**
     * Set the delimiter to use between statements.
     * @param $delimiter
     */
    public function setDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;
    }

    /**
     * Get the DDL statements for setting the SQL mode whilst preserving the original SQL mode.
     * @return string
     */
    public function getSetStatements()
    {
        return <<<SQL
SET @_schnoop_sql_mode = @@session.sql_mode{$this->delimiter}
SET @@session.sql_mode = '{$this->mode}'{$this->delimiter}
SQL;
    }

    /**
     * Get the DDL statements for restoring the previously changed SQL mode.
     * @return string
     */
    public function getRestoreStatements()
    {
        return <<<SQL
SET @@session.sql_mode = @_schnoop_sql_mode{$this->delimiter}
SET @_schnoop_sql_mode = NULL{$this->delimiter}
SQL;
    }
}
