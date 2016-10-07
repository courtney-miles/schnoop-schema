<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;

interface RoutineParameterInterface
{
    /**
     * Get the parameter name.
     * @return string
     */
    public function getName();

    /**
     * Set the parameter name.
     * @param $name
     */
    public function setName($name);

    /**
     * Get the parameter data type.
     * @return DataTypeInterface
     */
    public function getDataType();

    /**
     * Set the parameter data type.
     * @param DataTypeInterface $dataType
     */
    public function setDataType(DataTypeInterface $dataType);

    /**
     * Get the DDL for the parameter.
     * @return string
     */
    public function getDDL();

    /**
     * DDL for the parameter.
     * @uses RoutineParameterInterface::getDDL();
     * @return string
     */
    public function __toString();
}
