<?php

namespace MilesAsylum\SchnoopSchema\MySQL\SetVar;

class SqlMode
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

    public function getAssignStmt()
    {
        return <<<SQL
SET @_schnoop_sql_mode = @@session.sql_mode;
SET @@session.sql_mode = '{$this->mode}';
SQL;
    }

    public function getRestoreStmt()
    {
        return <<<SQL
SET @@session.sql_mode = @_schnoop_sql_mode;
SET @_schnoop_sql_mode = NULL;
SQL;
    }
}
