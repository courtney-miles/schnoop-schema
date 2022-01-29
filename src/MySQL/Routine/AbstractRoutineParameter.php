<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;

abstract class AbstractRoutineParameter implements RoutineParameterInterface
{
    /**
     * Parameter name.
     *
     * @var string
     */
    protected $name;

    /**
     * Parameter data type.
     *
     * @var DataTypeInterface
     */
    protected $dataType;

    /**
     * AbstractRoutineParameter constructor.
     *
     * @param string $name Parameter name
     * @param DataTypeInterface $dataType parameter data type
     */
    public function __construct($name, DataTypeInterface $dataType)
    {
        $this->name = $name;
        $this->dataType = $dataType;
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
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * {@inheritdoc}
     */
    public function setDataType(DataTypeInterface $dataType): void
    {
        $this->dataType = $dataType;
    }
}
