<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Database;

class Database implements DatabaseInterface
{
    protected $name;

    /**
     * @var string
     */
    protected $defaultCharacterSet;

    /**
     * @var string
     */
    protected $defaultCollation;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDefaultCollation()
    {
        return $this->defaultCollation;
    }

    public function hasDefaultCollation()
    {
        return !empty($this->defaultCollation);
    }

    public function setDefaultCollation($defaultCollation)
    {
        $this->defaultCollation = $defaultCollation;
    }

    /**
     * {@inheritdoc}
     */
    public function getDDL(
        $delimiter = self::DEFAULT_DELIMITER,
        $drop = self::DDL_DROP_DO_NOT
    ) {
        $dropDDL = $createDDL = '';

        if ($drop) {
            switch ($drop) {
                case self::DDL_DROP_ALWAYS:
                    $dropDDL = <<<SQL
DROP DATABASE `{$this->getName()}`{$delimiter}\n
SQL;
                    break;
                case self::DDL_DROP_IF_EXISTS:
                    $dropDDL = <<<SQL
DROP DATABASE IF EXISTS `{$this->getName()}`{$delimiter}\n
SQL;
                    break;
            }
        }

        $createDDL = "CREATE DATABASE `{$this->getName()}`"
            . ($this->hasDefaultCollation() ? " DEFAULT COLLATE '{$this->getDefaultCollation()}'" : null)
            . $delimiter;

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

    public function __toString()
    {
        return $this->getDDL();
    }
}
