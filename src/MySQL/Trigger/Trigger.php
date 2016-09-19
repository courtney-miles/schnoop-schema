<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Trigger;

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
    protected $statement;

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

    public function getStatement()
    {
        return $this->statement;
    }

    public function hasStatement()
    {
        return (bool)strlen($this->statement);
    }

    public function setStatement($statement)
    {
        $this->statement = $statement;
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

    public function getDDL($forceSqlMode = false, $delimiter = ';')
    {
        $forceSqlMode = $forceSqlMode && $this->hasSqlMode();
        $createDDL = '';

        $tableName = $this->hasDatabaseName() ? "`{$this->getDatabaseName()}`." : null;
        $tableName .= "`{$this->getTableName()}`";

        $triggerOrder = null;

        if ($this->hasPosition()) {
            $triggerOrder = "{$this->getPositionRelation()} `{$this->getPositionRelativeTo()}`";
        }

        if ($forceSqlMode) {
            $createDDL .= $this->sqlMode->getAssignStmt() . "\n";
        }

        $createDDL .= 'CREATE '
            . implode(
                "\n",
                array_filter(
                    [
                        !empty($this->hasDefiner()) ? 'DEFINER = ' . $this->getDefiner() : null,
                        "TRIGGER `{$this->getName()}` {$this->getTiming()} {$this->getEvent()}",
                        "ON $tableName FOR EACH ROW",
                        $triggerOrder,
                        $this->getStatement(),
                        $delimiter
                    ]
                )
            );

        if ($forceSqlMode) {
            $createDDL .= "\n" . $this->sqlMode->getRestoreStmt();
        }

        return $createDDL;
    }

    public function __toString()
    {
        return $this->getDDL();
    }
}
