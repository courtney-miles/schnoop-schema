<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;

class FunctionRoutine extends AbstractRoutine implements FunctionRoutineInterface
{
    /**
     * @var FunctionParameterInterface[]
     */
    protected $parameters = [];

    /**
     * @var DataTypeInterface
     */
    protected $returns;

    public function __construct($name, DataTypeInterface $return)
    {
        parent::__construct($name);

        $this->returns = $return;
    }

    /**
     * @return FunctionParameterInterface[]
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    public function hasParameters()
    {
        return !empty($this->parameters);
    }

    /**
     * @param FunctionParameterInterface[] $parameters
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public function addParameter(FunctionParameterInterface $parameter)
    {
        $this->parameters[] = $parameter;
    }

    /**
     * @return DataTypeInterface
     */
    public function getReturns()
    {
        return $this->returns;
    }

    /**
     * @param DataTypeInterface $returns
     */
    public function setReturns(DataTypeInterface $returns)
    {
        $this->returns = $returns;
    }

    public function __toString()
    {
        $functionSignature = 'FUNCTION ' . $this->getFullyQualifiedRoutineName()
            . ' (' . $this->getParametersDDL() . ')';

        $createDDL = 'CREATE '
            . implode(
                "\n",
                array_filter(
                    [
                        (!empty($this->definer)) ? 'DEFINER = ' . $this->definer : null,
                        $functionSignature,
                        'RETURNS ' . (string)$this->returns,
                        $this->getCharacteristicsDDL(),
                        'BEGIN',
                        $this->body,
                        'END'
                    ]
                )
            );

        return $createDDL;
    }

    protected function getParametersDDL()
    {
        $params = [];

        foreach ($this->parameters as $parameter) {
            $params[] = (string)$parameter;
        }

        return implode(',', $params);
    }
}
