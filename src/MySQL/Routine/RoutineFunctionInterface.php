<?php
namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;

interface RoutineFunctionInterface extends RoutineInterface
{
    /**
     * Get The parameters for the function.
     * @return FunctionParameterInterface[]
     */
    public function getParameters();

    /**
     * Identify if the function has any parameters
     * @return bool True if the function has at least one parameter.
     */
    public function hasParameters();

    /**
     * Set the parameters for the function.
     * @param FunctionParameterInterface[] $parameters
     */
    public function setParameters(array $parameters);

    /**
     * Add a parameter to the function.
     * @param FunctionParameterInterface $parameter
     * @return mixed
     */
    public function addParameter(FunctionParameterInterface $parameter);

    /**
     * Get the return type for the function
     * @return DataTypeInterface Data type.
     */
    public function getReturns();

    /**
     * Sets the return type for the function.
     * @param DataTypeInterface $return
     */
    public function setReturns(DataTypeInterface $return);
}
