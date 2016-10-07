<?php
namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

interface RoutineProcedureInterface extends RoutineInterface
{
    /**
     * Get the procedure parameters.
     * @return ProcedureParameterInterface[]
     */
    public function getParameters();

    /**
     * Identify if the procedure has any parameters
     * @return bool True if the procedure has at least one parameter.
     */
    public function hasParameters();

    /**
     * Set the parameters for the procedure.
     * @param ProcedureParameterInterface[] $parameters
     */
    public function setParameters(array $parameters);

    /**
     * Add a parameter to the procedure.
     * @param ProcedureParameterInterface $parameter
     */
    public function addParameter(ProcedureParameterInterface $parameter);
}
