<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;

interface ProcedureParameterInterface extends RoutineParameterInterface
{
    const DIRECTION_IN = 'IN';
    const DIRECTION_OUT = 'OUT';
    const DIRECTION_INOUT = 'INOUT';

    public function getDirection();
}
