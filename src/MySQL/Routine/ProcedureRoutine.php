<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

class ProcedureRoutine extends AbstractRoutine implements ProcedureRoutineInterface
{
    /**
     * @var ProcedureParameterInterface[]
     */
    protected $parameters = [];

    /**
     * @return ProcedureParameterInterface[]
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
     * @param ProcedureParameterInterface[] $parameters
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public function addParameter(ProcedureParameterInterface $parameter)
    {
        $this->parameters[] = $parameter;
    }

    public function getDDL($forceSqlMode = false)
    {
        $forceSqlMode = $forceSqlMode && $this->hasSqlMode();
        $createDDL = '';

        if ($forceSqlMode) {
            $createDDL .= $this->sqlMode->getAssignStmt() . "\n";
        }

        $procedureSignature = 'PROCEDURE ' . $this->getFullyQualifiedRoutineName()
            . ' (' . $this->getParametersDDL() . ')';

        $createDDL = 'CREATE '
            . implode(
                "\n",
                array_filter(
                    [
                        (!empty($this->definer)) ? 'DEFINER = ' . $this->definer : null,
                        $procedureSignature,
                        $this->getCharacteristicsDDL(),
                        'BEGIN',
                        $this->body,
                        'END'
                    ]
                )
            );

        if ($forceSqlMode) {
            $createDDL .= ";\n" . $this->sqlMode->getRestoreStmt();
        }

        return $createDDL;
    }

    public function __toString()
    {
        return $this->getDDL();
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
