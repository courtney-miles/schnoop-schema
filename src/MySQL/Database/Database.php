<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Database;

class Database implements DatabaseInterface
{
    /**
     * The database name.
     * @var string
     */
    protected $name;

    /**
     * The default collation for the database.
     * @var string
     */
    protected $defaultCollation;

    /**
     * The delimiter to use between statements.
     * @var string
     */
    protected $ddlDelimiter = self::DEFAULT_DELIMITER;

    /**
     * Whether to include a drop statement with the create statement.
     * @var bool
     */
    protected $ddlDropPolicy = self::DDL_DROP_POLICY_DO_NOT_DROP;

    /**
     * Database constructor.
     * @param string $name The database name.
     */
    public function __construct($name)
    {
        $this->name = $name;
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
    public function getDefaultCollation()
    {
        return $this->defaultCollation;
    }

    /**
     * {@inheritdoc}
     */
    public function hasDefaultCollation()
    {
        return !empty($this->defaultCollation);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultCollation($defaultCollation)
    {
        $this->defaultCollation = $defaultCollation;
    }

    /**
     * {@inheritdoc}
     */
    public function getDelimiter()
    {
        return $this->ddlDelimiter;
    }

    /**
     * {@inheritdoc}
     */
    public function setDelimiter($delimiter)
    {
        $this->ddlDelimiter = $delimiter;
    }

    /**
     * {@inheritdoc}
     */
    public function getDropPolicy()
    {
        return $this->ddlDropPolicy;
    }

    /**
     * {@inheritdoc}
     */
    public function setDropPolicy($ddlDropPolicyPolicy)
    {
        $this->ddlDropPolicy = $ddlDropPolicyPolicy;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreateStatement()
    {
        $dropDDL = $createDDL = '';

        if ($this->ddlDropPolicy) {
            switch ($this->ddlDropPolicy) {
                case self::DDL_DROP_POLICY_DROP:
                    $dropDDL = <<<SQL
DROP DATABASE `{$this->getName()}`{$this->ddlDelimiter}
SQL;
                    break;
                case self::DDL_DROP_POLICY_DROP_IF_EXISTS:
                    $dropDDL = <<<SQL
DROP DATABASE IF EXISTS `{$this->getName()}`{$this->ddlDelimiter}
SQL;
                    break;
            }
        }

        $createDDL = "CREATE DATABASE `{$this->getName()}`"
            . ($this->hasDefaultCollation() ? " DEFAULT COLLATE '{$this->getDefaultCollation()}'" : null)
            . $this->ddlDelimiter;

        $createDDL = implode(
            "\n",
            array_filter(
                [
                    $dropDDL,
                    $createDDL
                ]
            )
        );

        return $createDDL;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getCreateStatement();
    }
}
