<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

abstract class AbstractConstraint implements ConstraintInterface
{
    /**
     * Constraint name.
     * @var string
     */
    protected $name;

    /**
     * Constraint type.
     * @var string
     */
    protected $constraintType;

    /**
     * Name of the table the constraint belongs to.
     * @var string
     */
    protected $tableName;

    /**
     * Name of the database the constraint belongs to.
     * @var string
     */
    protected $databaseName;

    /**
     * AbstractConstraint constructor.
     * @param string $name Constraint name
     * @param string $constraintType Constraint type.  One of self::CONSTRAINT_* constants.
     */
    public function __construct($name, $constraintType)
    {
        $this->name = $name;
        $this->constraintType = $constraintType;
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
    public function getConstraintType()
    {
        return $this->constraintType;
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
    public function hasTableName()
    {
        return isset($this->tableName);
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
        return isset($this->databaseName);
    }

    /**
     * {@inheritdoc}
     */
    public function setDatabaseName($databaseName)
    {
        $this->databaseName = $databaseName;
    }
}
