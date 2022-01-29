<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

interface RoutineProcedureInterface extends RoutineInterface
{
    /**
     * Get the procedure parameters.
     *
     * @return ProcedureParameterInterface[]
     */
    public function getParameters();

    /**
     * Identify if the procedure has any parameters.
     *
     * @return bool true if the procedure has at least one parameter
     */
    public function hasParameters();

    /**
     * Set the parameters for the procedure.
     *
     * @param ProcedureParameterInterface[] $parameters
     */
    public function setParameters(array $parameters);

    /**
     * Add a parameter to the procedure.
     */
    public function addParameter(ProcedureParameterInterface $parameter);
}
