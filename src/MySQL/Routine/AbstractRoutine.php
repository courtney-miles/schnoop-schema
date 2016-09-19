<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\SetVar\SqlMode;

abstract class AbstractRoutine implements RoutineInterface
{
    /**
     * @var
     */
    protected $name;

    protected $databaseName;

    protected $definer = self::DEFINER_CURRENT_USER;

    protected $comment;

    protected $deterministic = false;

    protected $dataAccess = self::DATA_ACCESS_CONTAINS_SQL;

    protected $sqlSecurity = self::SECURITY_DEFINER;

    protected $body = '';

    /**
     * @var SqlMode
     */
    protected $sqlMode;

    public function __construct($name)
    {
        $this->name = $name;
        $this->setDefiner(self::DEFINER_CURRENT_USER);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDatabaseName()
    {
        return $this->databaseName;
    }

    public function hasDatabaseName()
    {
        return !empty($this->databaseName);
    }

    public function setDatabaseName($databaseName)
    {
        $this->databaseName = $databaseName;
    }

    /**
     * @return mixed
     */
    public function getDefiner()
    {
        return $this->definer;
    }

    /**
     * @param mixed $definer
     */
    public function setDefiner($definer)
    {
        $this->definer = $definer;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function hasComment()
    {
        return !empty($this->comment);
    }

    /**
     * @return boolean
     */
    public function isDeterministic()
    {
        return $this->deterministic;
    }

    /**
     * @param boolean $deterministic
     */
    public function setDeterministic($deterministic)
    {
        $this->deterministic = $deterministic;
    }

    /**
     * @return mixed
     */
    public function getDataAccess()
    {
        return $this->dataAccess;
    }

    /**
     * @param mixed $dataAccess
     */
    public function setDataAccess($dataAccess)
    {
        $this->dataAccess = $dataAccess;
    }

    /**
     * @return mixed
     */
    public function getSqlSecurity()
    {
        return $this->sqlSecurity;
    }

    /**
     * @param mixed $sqlSecurity
     */
    public function setSqlSecurity($sqlSecurity)
    {
        $this->sqlSecurity = $sqlSecurity;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getSqlMode()
    {
        return $this->sqlMode;
    }

    public function hasSqlMode()
    {
        return isset($this->sqlMode);
    }

    public function setSqlMode(SqlMode $sqlMode)
    {
        $this->sqlMode = $sqlMode;
    }

    protected function getFullyQualifiedRoutineName()
    {
        $databasePre = !empty($this->databaseName) ? '`' . $this->databaseName . '`.' : null;

        return $databasePre . '`' . $this->name . '`';
    }

    protected function getCharacteristicsDDL()
    {
        return implode(
            " ",
            array_filter(
                [
                    $this->deterministic ? 'DETERMINISTIC' : 'NOT DETERMINISTIC',
                    $this->dataAccess,
                    !empty($this->sqlSecurity) ? 'SQL SECURITY ' . $this->sqlSecurity : null,
                    !empty($this->comment) ? "\nCOMMENT '" . addslashes($this->comment) . "'" : null
                ]
            )
        );
    }
}
