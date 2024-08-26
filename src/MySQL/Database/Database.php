<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\Database;

class Database implements DatabaseInterface
{
    /**
     * The database name.
     *
     * @var string
     */
    protected $name;

    /**
     * The default collation for the database.
     *
     * @var string
     */
    protected $defaultCollation;

    /**
     * The delimiter to use between statements.
     *
     * @var string
     */
    protected $ddlDelimiter = self::DEFAULT_DELIMITER;

    /**
     * Whether to include a drop statement with the create statement.
     *
     * @var bool
     */
    protected $ddlDropPolicy = self::DDL_DROP_POLICY_DO_NOT_DROP;

    /**
     * Database constructor.
     *
     * @param string $name the database name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDefaultCollation()
    {
        return $this->defaultCollation;
    }

    public function hasDefaultCollation()
    {
        return !empty($this->defaultCollation);
    }

    public function setDefaultCollation($defaultCollation): void
    {
        $this->defaultCollation = $defaultCollation;
    }

    public function getDelimiter()
    {
        return $this->ddlDelimiter;
    }

    public function setDelimiter($delimiter): void
    {
        $this->ddlDelimiter = $delimiter;
    }

    public function getDropPolicy()
    {
        return $this->ddlDropPolicy;
    }

    public function setDropPolicy($ddlDropPolicyPolicy): void
    {
        $this->ddlDropPolicy = $ddlDropPolicyPolicy;
    }

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
                    $createDDL,
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
