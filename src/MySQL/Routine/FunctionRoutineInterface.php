<?php
namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;

interface FunctionRoutineInterface extends RoutineInterface
{
    /**
     * @return FunctionParameterInterface[]
     */
    public function getParameters();

    /**
     * @return bool
     */
    public function hasParameters();

    /**
     * @param FunctionParameterInterface[] $parameters
     */
    public function setParameters(array $parameters);

    public function addParameter(FunctionParameterInterface $parameter);

    /**
     * @return DataTypeInterface
     */
    public function getReturns();

    /**
     * @param DataTypeInterface $return
     */
    public function setReturns(DataTypeInterface $return);
}
