<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Trigger;

use MilesAsylum\SchnoopSchema\MySQL\Exception\ForceSqlModeException;
use MilesAsylum\SchnoopSchema\MySQL\Exception\FQNException;
use MilesAsylum\SchnoopSchema\MySQL\SetVar\SqlMode;

class Trigger implements TriggerInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $tableName;

    /**
     * @var string
     */
    protected $databaseName;

    /**
     * @var string
     */
    protected $definer;

    /**
     * @var string
     */
    protected $event;

    /**
     * @var string
     */
    protected $timing;

    /**
     * @var string
     */
    protected $body;

    protected $positionRelation;

    protected $positionRelativeTo;

    /**
     * @var SqlMode
     */
    protected $sqlMode;

    public function __construct($name, $timing, $event, $tableName)
    {
        $this->setName($name);
        $this->setTiming($timing);
        $this->setEvent($event);
        $this->setTableName($tableName);
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
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

    public function hasDefiner()
    {
        return !empty($this->definer);
    }

    /**
     * @param mixed $definer
     */
    public function setDefiner($definer)
    {
        $this->definer = $definer;
    }

    public function getEvent()
    {
        return $this->event;
    }

    public function setEvent($event)
    {
        $this->event = $event;
    }

    public function getTiming()
    {
        return $this->timing;
    }

    public function setTiming($timing)
    {
        $this->timing = $timing;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function hasBody()
    {
        return (bool)strlen($this->body);
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getPositionRelation()
    {
        return $this->positionRelation;
    }

    public function getPositionRelativeTo()
    {
        return $this->positionRelativeTo;
    }

    public function hasPosition()
    {
        return !empty($this->positionRelativeTo);
    }

    public function setPosition($relation, $relativeTo)
    {
        $this->positionRelation = $relation;
        $this->positionRelativeTo = $relativeTo;
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

    /**
     * {@inheritdoc}
     */
    public function getDDL(
        $forceSqlMode = false,
        $delimiter = self::DEFAULT_DELIMITER,
        $fullyQualifiedName = false,
        $drop = self::DDL_DROP_DO_NOT
    ) {
        $dropDDL = $setSqlMode = $createDDL = $revertSqlMode = '';

        if ($fullyQualifiedName) {
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
            $triggerOrder = "{$this->getPositionRelation()} `{$this->getPositionRelativeTo()}`";
        }

        if ($drop) {
            switch ($drop) {
                case self::DDL_DROP_ALWAYS:
                    $dropDDL = <<<SQL
DROP TRIGGER {$triggerName}{$delimiter}
SQL;
                    break;
                case self::DDL_DROP_IF_EXISTS:
                    $dropDDL = <<<SQL
DROP TRIGGER IF EXISTS {$triggerName}{$delimiter}
SQL;
                    break;
            }
        }

        if ($forceSqlMode) {
            if (!$this->hasSqlMode()) {
                throw new ForceSqlModeException(
                    'Unable to create DDL that forces the SQL mode because an SQL mode has not been set.'
                );
            }

            $setSqlMode = $this->sqlMode->getAssignStmt($delimiter);
            $revertSqlMode = $this->sqlMode->getRestoreStmt($delimiter);
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
                        $delimiter
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
