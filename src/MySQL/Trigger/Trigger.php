<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Trigger;

use MilesAsylum\SchnoopSchema\MySQL\Exception\FQNException;
use MilesAsylum\SchnoopSchema\MySQL\SetVar\SqlMode;

class Trigger implements TriggerInterface
{
    /**
     * Trigger Name.
     * @var string
     */
    protected $name;

    /**
     * Table name.
     * @var string
     */
    protected $tableName;

    /**
     * Database name.
     * @var string
     */
    protected $databaseName;

    /**
     * Trigger definer.
     * @var string
     */
    protected $definer;

    /**
     * Trigger event.
     * @var string
     */
    protected $event;

    /**
     * Trigger timing.
     * @var string
     */
    protected $timing;

    /**
     * Trigger logic.
     * @var string
     */
    protected $body;

    /**
     * Position context. One of self::POSITION_* constants.
     * @var string
     */
    protected $positionContext;

    /**
     * Name of trigger this trigger position is relative to.
     * @var string
     */
    protected $positionRelativeTo;

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
     * Trigger SQL mode.
     * @var SqlMode
     */
    protected $sqlMode;

    /**
     * Trigger constructor.
     * @param string $name Trigger name
     * @param string $timing Trigger timing.  One of self::TIMING_* constants.
     * @param string $event Trigger event. One of self::EVENT_* constants.
     * @param string $tableName Name of table the trigger is for.
     */
    public function __construct($name, $timing, $event, $tableName)
    {
        $this->setName($name);
        $this->setTiming($timing);
        $this->setEvent($event);
        $this->setTableName($tableName);
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
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * {@inheritdoc}
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
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
    public function hasDefiner()
    {
        return !empty($this->definer);
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
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * {@inheritdoc}
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }

    /**
     * {@inheritdoc}
     */
    public function getTiming()
    {
        return $this->timing;
    }

    /**
     * {@inheritdoc}
     */
    public function setTiming($timing)
    {
        $this->timing = $timing;
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
    public function hasBody()
    {
        return (bool)strlen($this->body);
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
    public function getPositionContext()
    {
        return $this->positionContext;
    }

    /**
     * {@inheritdoc}
     */
    public function getPositionRelativeTo()
    {
        return $this->positionRelativeTo;
    }

    /**
     * {@inheritdoc}
     */
    public function hasPosition()
    {
        return !empty($this->positionRelativeTo);
    }

    /**
     * {@inheritdoc}
     */
    public function setPosition($positionContext, $relativeTo)
    {
        $this->positionContext = $positionContext;
        $this->positionRelativeTo = $relativeTo;
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
     * {@inheritdoc}
     */
    public function getDDL()
    {
        $dropDDL = $setSqlMode = $createDDL = $revertSqlMode = '';

        if ($this->ddlUseFullyQualifiedName) {
            if (!$this->hasDatabaseName()) {
                throw new FQNException(
                    'Unable to create DDL with fully-qualified-name because the database name has not been set.'
                );
            }

            $tableName = "`{$this->getDatabaseName()}`.`{$this->getTableName()}`";
            $triggerName = "`{$this->getDatabaseName()}`.`{$this->getName()}`";
        } else {
            $tableName = "`{$this->getTableName()}`";
            $triggerName = "`{$this->getName()}`";
        }

        $triggerOrder = null;

        if ($this->hasPosition()) {
            $triggerOrder = "{$this->getPositionContext()} `{$this->getPositionRelativeTo()}`";
        }

        if ($this->ddlDropPolicy) {
            switch ($this->ddlDropPolicy) {
                case self::DDL_DROP_DOES_EXISTS:
                    $dropDDL = <<<SQL
DROP TRIGGER {$triggerName}{$this->ddlDelimiter}
SQL;
                    break;
                case self::DDL_DROP_IF_EXISTS:
                    $dropDDL = <<<SQL
DROP TRIGGER IF EXISTS {$triggerName}{$this->ddlDelimiter}
SQL;
                    break;
            }
        }

        if ($this->hasSqlMode()) {
            $setSqlMode = $this->sqlMode->getAssignStmt($this->ddlDelimiter);
            $revertSqlMode = $this->sqlMode->getRestoreStmt($this->ddlDelimiter);
        }

        $createDDL .= 'CREATE '
            . implode(
                "\n",
                array_filter(
                    [
                        !empty($this->hasDefiner()) ? 'DEFINER = ' . $this->getDefiner() : null,
                        "TRIGGER {$triggerName} {$this->getTiming()} {$this->getEvent()}",
                        "ON {$tableName} FOR EACH ROW",
                        $triggerOrder,
                        'BEGIN',
                        $this->getBody(),
                        'END',
                        $this->ddlDelimiter
                    ]
                )
            );

        $createDDL = implode(
            "\n",
            array_filter(
                [
                    $dropDDL,
                    $setSqlMode,
                    $createDDL,
                    $revertSqlMode
                ]
            )
        );

        return $createDDL;
    }

    public function __toString()
    {
        return $this->getDDL();
    }
}
