<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

interface ProcedureParameterInterface extends RoutineParameterInterface
{
    const DIRECTION_IN = 'IN';
    const DIRECTION_OUT = 'OUT';
    const DIRECTION_INOUT = 'INOUT';

    /**
     * Get the direction for parameter.
     * @return string One of ProcedureParameterInterface::DIRECTION_* constants.
     */
    public function getDirection();
}
