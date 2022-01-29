<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\Trigger;

use MilesAsylum\SchnoopSchema\MySQL\Exception\FQNException;
use MilesAsylum\SchnoopSchema\MySQL\SetVar\SqlMode;

class Trigger implements TriggerInterface
{
    /**
     * Trigger Name.
     *
     * @var string
     */
    protected $name;

    /**
     * Table name.
     *
     * @var string
     */
    protected $tableName;

    /**
     * Database name.
     *
     * @var string
     */
    protected $databaseName;

    /**
     * Trigger definer.
     *
     * @var string
     */
    protected $definer;

    /**
     * Trigger event.
     *
     * @var string
     */
    protected $event;

    /**
     * Trigger timing.
     *
     * @var string
     */
    protected $timing;

    /**
     * Trigger logic.
     *
     * @var string
     */
    protected $body;

    /**
     * Position context. One of self::POSITION_* constants.
     *
     * @var string
     */
    protected $positionContext;

    /**
     * Name of trigger this trigger position is relative to.
     *
     * @var string
     */
    protected $positionRelativeTo;

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
     * Trigger SQL mode.
     *
     * @var SqlMode
     */
    protected $sqlMode;

    /**
     * Trigger constructor.
     *
     * @param string $name Trigger name
     * @param string $timing Trigger timing.  One of self::TIMING_* constants.
     * @param string $event Trigger event. One of self::EVENT_* constants.
     * @param string $tableName name of table the trigger is for
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
    public function setName($name): void
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
    public function setTableName($tableName): void
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
    public function hasDefiner()
    {
        return !empty($this->definer);
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
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * {@inheritdoc}
     */
    public function setEvent($event): void
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
    public function setTiming($timing): void
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
        return null !== $this->body && '' !== $this->body;
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
    public function setPosition($positionContext, $relativeTo): void
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
     * {@inheritdoc}
     */
    public function getCreateStatement()
    {
        $dropDDL = $setSqlMode = $createDDL = $revertSqlMode = '';

        if ($this->useFullyQualifiedName) {
            if (!$this->hasDatabaseName()) {
                throw new FQNException('Unable to create DDL with fully-qualified-name because the database name has not been set.');
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

        if ($this->dropPolicy) {
            switch ($this->dropPolicy) {
                case self::DDL_DROP_POLICY_DROP:
                    $dropDDL = <<<SQL
DROP TRIGGER {$triggerName}{$this->delimiter}
SQL;
                    break;
                case self::DDL_DROP_POLICY_DROP_IF_EXISTS:
                    $dropDDL = <<<SQL
DROP TRIGGER IF EXISTS {$triggerName}{$this->delimiter}
SQL;
                    break;
            }
        }

        if ($this->hasSqlMode()) {
            $prevDelimiter = $this->sqlMode->getDelimiter();
            $this->sqlMode->setDelimiter($this->delimiter);

            $setSqlMode = $this->sqlMode->getSetStatements();
            $revertSqlMode = $this->sqlMode->getRestoreStatements();

            $this->sqlMode->setDelimiter($prevDelimiter);
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
                        'END' . $this->delimiter,
                    ]
                )
            );

        $createDDL = implode(
            "\n",
            array_filter(
                [
                    $setSqlMode,
                    $dropDDL,
                    $createDDL,
                    $revertSqlMode,
                ]
            )
        );

        return $createDDL;
    }

    public function __toString()
    {
        return $this->getCreateStatement();
    }
}
