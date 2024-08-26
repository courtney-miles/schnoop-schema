<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

abstract class AbstractConstraint implements ConstraintInterface
{
    /**
     * Constraint name.
     *
     * @var string
     */
    protected $name;

    /**
     * Constraint type.
     *
     * @var string
     */
    protected $constraintType;

    /**
     * Name of the table the constraint belongs to.
     *
     * @var string
     */
    protected $tableName;

    /**
     * Name of the database the constraint belongs to.
     *
     * @var string
     */
    protected $databaseName;

    /**
     * AbstractConstraint constructor.
     *
     * @param string $name Constraint name
     * @param string $constraintType Constraint type.  One of self::CONSTRAINT_* constants.
     */
    public function __construct($name, $constraintType)
    {
        $this->name = $name;
        $this->constraintType = $constraintType;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getConstraintType()
    {
        return $this->constraintType;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function setTableName($tableName): void
    {
        $this->tableName = $tableName;
    }

    public function hasTableName()
    {
        return isset($this->tableName);
    }

    public function getDatabaseName()
    {
        return $this->databaseName;
    }

    public function hasDatabaseName()
    {
        return isset($this->databaseName);
    }

    public function setDatabaseName($databaseName): void
    {
        $this->databaseName = $databaseName;
    }
}
