<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;

interface RoutineParameterInterface
{
    /**
     * @return string
     */
    public function getName();

    public function setName($name);

    /**
     * @return DataTypeInterface
     */
    public function getDataType();

    public function setDataType(DataTypeInterface $dataType);

    public function __toString();
}
