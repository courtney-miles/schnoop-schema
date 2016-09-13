<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;

abstract class AbstractRoutineParameter implements RoutineParameterInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var DataTypeInterface
     */
    protected $dataType;

    public function __construct($name, DataTypeInterface $dataType)
    {
        $this->name = $name;
        $this->dataType = $dataType;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDataType()
    {
        return $this->dataType;
    }

    public function setDataType(DataTypeInterface $dataType)
    {
        $this->dataType = $dataType;
    }
}
