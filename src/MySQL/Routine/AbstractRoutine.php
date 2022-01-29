<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\Exception\FQNException;
use MilesAsylum\SchnoopSchema\MySQL\SetVar\SqlMode;

abstract class AbstractRoutine implements RoutineInterface
{
    /**
     * Routine name.
     *
     * @var string
     */
    protected $name;

    /**
     * Database name.
     *
     * @var string
     */
    protected $databaseName;

    /**
     * Routine definer.
     *
     * @var string
     */
    protected $definer = self::DEFINER_CURRENT_USER;

    /**
     * Routine comment.
     *
     * @var string
     */
    protected $comment;

    /**
     * If the routine is deterministic.
     *
     * @var bool
     */
    protected $deterministic = false;

    /**
     * Data access.
     *
     * @var string
     */
    protected $dataAccess = self::DATA_ACCESS_CONTAINS_SQL;

    /**
     * SQL security.
     *
     * @var string
     */
    protected $sqlSecurity = self::SECURITY_DEFINER;

    /**
     * Routine body.
     *
     * @var string
     */
    protected $body = '';

    /**
     * @var SqlMode
     */
    protected $sqlMode;

    /**
     * The delimiter to use between statements.
     *
     * @var string
     */
    protected $delimiter = self::DEFAULT_DELIMITER;

    /**
     * Whether to include a drop statement with the create statement.
     *
     * @var bool
     */
    protected $dropPolicy = self::DDL_DROP_POLICY_DO_NOT_DROP;

    /**
     * Whether the DDL will use the fully qualified name for resources.
     *
     * @var bool
     */
    protected $useFullyQualifiedName = false;

    /**
     * AbstractRoutine constructor.
     *
     * @param string $name routine name
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
    public function setDatabaseName($databaseName): void
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
    public function setDefiner($definer): void
    {
        $this->definer = $definer;
    }

    /**
     * {@inheritdoc}
     */
    public function hasDefiner()
    {
        return !empty($this->definer);
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
    public function setComment($comment): void
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
    public function setDeterministic($deterministic): void
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
    public function setDataAccess($dataAccess): void
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
    public function setSqlSecurity($sqlSecurity): void
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
    public function setBody($body): void
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
    public function setSqlMode(SqlMode $sqlMode): void
    {
        $this->sqlMode = $sqlMode;
    }

    public function unsetSqlMode(): void
    {
        $this->sqlMode = null;
    }

    /**
     * {@inheritdoc}
     */
    public function getDelimiter()
    {
        return $this->delimiter;
    }

    /**
     * {@inheritdoc}
     */
    public function setDelimiter($delimiter): void
    {
        $this->delimiter = $delimiter;
    }

    /**
     * {@inheritdoc}
     */
    public function getDropPolicy()
    {
        return $this->dropPolicy;
    }

    /**
     * {@inheritdoc}
     */
    public function setDropPolicy($ddlDropPolicy): void
    {
        $this->dropPolicy = $ddlDropPolicy;
    }

    /**
     * {@inheritdoc}
     */
    public function useFullyQualifiedName()
    {
        return $this->useFullyQualifiedName;
    }

    /**
     * {@inheritdoc}
     */
    public function setUseFullyQualifiedName($useFullyQualifiedName): void
    {
        $this->useFullyQualifiedName = $useFullyQualifiedName;
    }

    /**
     * Resolve the routine name to an enclosed name.
     *
     * @return string Routine name
     */
    protected function makeRoutineName()
    {
        if ($this->useFullyQualifiedName()) {
            if (!$this->hasDatabaseName()) {
                throw new FQNException('Unable to create DDL with fully-qualified-name because the database name has not been set.');
            }

            $routineName = "`{$this->getDatabaseName()}`.`{$this->getName()}`";
        } else {
            $routineName = "`{$this->getName()}`";
        }

        return $routineName;
    }

    /**
     * Make the portion of the routine DDL statement that describes deterministic, sql security and comment.
     *
     * @return string characteristics DDL
     */
    protected function makeCharacteristicsDDL()
    {
        return implode(
            ' ',
            array_filter(
                [
                    $this->deterministic ? 'DETERMINISTIC' : 'NOT DETERMINISTIC',
                    $this->dataAccess,
                    !empty($this->sqlSecurity) ? 'SQL SECURITY ' . $this->sqlSecurity : null,
                    !empty($this->comment) ? "\nCOMMENT '" . addslashes($this->comment) . "'" : null,
                ]
            )
        );
    }
}
