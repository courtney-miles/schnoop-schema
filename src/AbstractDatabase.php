<?php

namespace MilesAsylum\SchnoopSchema;

abstract class AbstractDatabase implements DatabaseInterface
{
    protected $name;

    public function __construct($name)
    {
        $this->setName($name);
    }

    public function getName()
    {
        return $this->name;
    }
    
    protected function setName($name)
    {
        $this->name = $name;
    }
}
