<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

interface ProcedureParameterInterface extends RoutineParameterInterface
{
    public const DIRECTION_IN = 'IN';
    public const DIRECTION_OUT = 'OUT';
    public const DIRECTION_INOUT = 'INOUT';

    /**
     * Get the direction for parameter.
     *
     * @return string one of ProcedureParameterInterface::DIRECTION_* constants
     */
    public function getDirection();
}
