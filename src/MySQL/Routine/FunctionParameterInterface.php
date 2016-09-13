<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

interface FunctionParameterInterface extends RoutineParameterInterface
{
    public function getDirection();
}
