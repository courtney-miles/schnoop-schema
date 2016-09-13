<?php
namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

interface ProcedureRoutineInterface extends RoutineInterface
{
    /**
     * @return ProcedureParameterInterface[]
     */
    public function getParameters();

    public function hasParameters();

    /**
     * @param ProcedureParameterInterface[] $parameters
     */
    public function setParameters(array $parameters);

    public function addParameter(ProcedureParameterInterface $parameter);
}
