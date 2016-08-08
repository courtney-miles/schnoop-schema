<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 4/06/16
 * Time: 6:10 PM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\Database;

use MilesAsylum\SchnoopSchema\AbstractDatabase;
use MilesAsylum\Schnoop\Schnoop;

class Database extends AbstractDatabase implements DatabaseInterface
{
    /**
     * @var string
     */
    protected $defaultCharacterSet;

    /**
     * @var string
     */
    protected $defaultCollation;
    
    /**
     * @var Schnoop
     */
    protected $schnoop;

    public function __construct($name, $collation = null)
    {
        parent::__construct($name);

        $this->setDefaultCollation($collation);
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

    public function __toString()
    {
        return "CREATE DATABASE `$this->name`"
            . ($this->hasDefaultCollation() ? " DEFAULT COLLATE '{$this->getDefaultCollation()}'" : null);
    }

    /**
     * @param string $characterSet
     */
    protected function setDefaultCharacterSet($characterSet)
    {
        $this->defaultCharacterSet = $characterSet;
    }

    /**
     * @param string $collation
     */
    protected function setDefaultCollation($collation)
    {
        $this->defaultCollation = $collation;
    }
}
