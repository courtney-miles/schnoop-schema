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

    public function __toString()
    {
        return "CREATE DATABASE `$this->name`"
            . ($this->hasDefaultCollation() ? " DEFAULT COLLATE '{$this->getDefaultCollation()}'" : null)
            . ';';
    }
}
