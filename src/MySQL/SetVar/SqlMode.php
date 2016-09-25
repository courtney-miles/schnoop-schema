<?php

namespace MilesAsylum\SchnoopSchema\MySQL\SetVar;

use MilesAsylum\SchnoopSchema\MySQL\MySQLInterface;

class SqlMode implements MySQLInterface
{
    protected $mode;

    public function __construct($mode)
    {
        $this->mode = $mode;
    }

    /**
     * @return mixed
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param mixed $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    public function getAssignStmt($delimiter = self::DEFAULT_DELIMITER)
    {
        return <<<SQL
SET @_schnoop_sql_mode = @@session.sql_mode{$delimiter}
SET @@session.sql_mode = '{$this->mode}'{$delimiter}
SQL;
    }

    public function getRestoreStmt($delimiter = self::DEFAULT_DELIMITER)
    {
        return <<<SQL
SET @@session.sql_mode = @_schnoop_sql_mode{$delimiter}
SET @_schnoop_sql_mode = NULL{$delimiter}
SQL;
    }
}
