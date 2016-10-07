<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\SetVar\SqlMode;

abstract class AbstractRoutine implements RoutineInterface
{
    /**
     * Routine name.
     * @var string
     */
    protected $name;

    /**
     * Database name.
     * @var string
     */
    protected $databaseName;

    /**
     * Routine definer.
     * @var string
     */
    protected $definer = self::DEFINER_CURRENT_USER;

    /**
     * Routine comment.
     * @var string
     */
    protected $comment;

    /**
     * If the routine is deterministic
     * @var bool
     */
    protected $deterministic = false;

    /**
     * Data access.
     * @var string
     */
    protected $dataAccess = self::DATA_ACCESS_CONTAINS_SQL;

    /**
     * SQL security
     * @var string
     */
    protected $sqlSecurity = self::SECURITY_DEFINER;

    /**
     * Routine body.
     * @var string
     */
    protected $body = '';

    /**
     * @var SqlMode
     */
    protected $sqlMode;

    /**
     * The delimiter to use between statements.
     * @var string
     */
    protected $ddlDelimiter = self::DEFAULT_DELIMITER;

    /**
     * Whether to include a drop statement with the create statement.
     * @var bool
     */
    protected $ddlDropPolicy = self::DDL_DROP_DO_NOT;

    /**
     * Whether the DDL will use the fully qualified name for resources.
     * @var bool
     */
    protected $ddlUseFullyQualifiedName = false;


    /**
     * AbstractRoutine constructor.
     * @param string $name Routine name.
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->setDefiner(self::DEFINER_CURRENT_USER);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getDatabaseName()
    {
        return $this->databaseName;
    }

    /**
     * {@inheritdoc}
     */
    public function hasDatabaseName()
    {
        return !empty($this->databaseName);
    }

    /**
     * {@inheritdoc}
     */
    public function setDatabaseName($databaseName)
    {
        $this->databaseName = $databaseName;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefiner()
    {
        return $this->definer;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefiner($definer)
    {
        $this->definer = $definer;
    }

    /**
     * {@inheritdoc}
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * {@inheritdoc}
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * {@inheritdoc}
     */
    public function hasComment()
    {
        return !empty($this->comment);
    }

    /**
     * {@inheritdoc}
     */
    public function isDeterministic()
    {
        return $this->deterministic;
    }

    /**
     * {@inheritdoc}
     */
    public function setDeterministic($deterministic)
    {
        $this->deterministic = $deterministic;
    }

    /**
     * {@inheritdoc}
     */
    public function getDataAccess()
    {
        return $this->dataAccess;
    }

    /**
     * {@inheritdoc}
     */
    public function setDataAccess($dataAccess)
    {
        $this->dataAccess = $dataAccess;
    }

    /**
     * {@inheritdoc}
     */
    public function getSqlSecurity()
    {
        return $this->sqlSecurity;
    }

    /**
     * {@inheritdoc}
     */
    public function setSqlSecurity($sqlSecurity)
    {
        $this->sqlSecurity = $sqlSecurity;
    }

    /**
     * {@inheritdoc}
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * {@inheritdoc}
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * {@inheritdoc}
     */
    public function getSqlMode()
    {
        return $this->sqlMode;
    }

    /**
     * {@inheritdoc}
     */
    public function hasSqlMode()
    {
        return isset($this->sqlMode);
    }

    /**
     * {@inheritdoc}
     */
    public function setSqlMode(SqlMode $sqlMode)
    {
        $this->sqlMode = $sqlMode;
    }

    public function unsetSqlMode()
    {
        $this->sqlMode = null;
    }

    /**
     * {@inheritdoc}
     */
    public function getDDLDelimiter()
    {
        return $this->ddlDelimiter;
    }

    /**
     * {@inheritdoc}
     */
    public function setDDLDelimiter($delimiter)
    {
        $this->ddlDelimiter = $delimiter;
    }

    /**
     * {@inheritdoc}
     */
    public function getDDLDropPolicy()
    {
        return $this->ddlDropPolicy;
    }

    /**
     * {@inheritdoc}
     */
    public function setDDLDropPolicy($ddlDropPolicy)
    {
        $this->ddlDropPolicy = $ddlDropPolicy;
    }

    /**
     * {@inheritdoc}
     */
    public function isDDLUseFullyQualifiedName()
    {
        return $this->ddlUseFullyQualifiedName;
    }

    /**
     * {@inheritdoc}
     */
    public function setDDLUseFullyQualifiedName($useFullyQualifiedName)
    {
        $this->ddlUseFullyQualifiedName = $useFullyQualifiedName;
    }

    /**
     * Make the fully qualified name for the routine.
     * @return string Fully qualified name
     */
    protected function makeFullyQualifiedRoutineName()
    {
        $databasePre = !empty($this->databaseName) ? '`' . $this->databaseName . '`.' : null;

        return $databasePre . '`' . $this->name . '`';
    }

    /**
     * Make the portion of the routine DDL statement that describes deterministic, sql security and comment.
     * @return string Characteristics DDL.
     */
    protected function makeCharacteristicsDDL()
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
