<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

class RoutineProcedure extends AbstractRoutine implements RoutineProcedureInterface
{
    /**
     * Routine parameters.
     *
     * @var ProcedureParameterInterface[]
     */
    protected $parameters = [];

    public function getParameters()
    {
        return $this->parameters;
    }

    public function hasParameters()
    {
        return !empty($this->parameters);
    }

    public function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }

    public function addParameter(ProcedureParameterInterface $parameter): void
    {
        $this->parameters[] = $parameter;
    }

    public function getCreateStatement()
    {
        $dropDDL = $setSqlMode = $createDDL = $revertSqlMode = '';

        $procedureName = $this->makeRoutineName();

        if ($this->dropPolicy) {
            switch ($this->dropPolicy) {
                case self::DDL_DROP_POLICY_DROP:
                    $dropDDL = <<<SQL
DROP PROCEDURE {$procedureName}{$this->delimiter}
SQL;
                    break;
                case self::DDL_DROP_POLICY_DROP_IF_EXISTS:
                    $dropDDL = <<<SQL
DROP PROCEDURE IF EXISTS {$procedureName}{$this->delimiter}
SQL;
                    break;
            }
        }

        if ($this->hasSqlMode()) {
            $prevDelimiter = $this->sqlMode->getDelimiter();
            $this->sqlMode->setDelimiter($this->delimiter);

            $setSqlMode = $this->sqlMode->getSetStatements();
            $revertSqlMode = $this->sqlMode->getRestoreStatements();

            $this->sqlMode->setDelimiter($prevDelimiter);
        }

        $paramsDDL = count($this->parameters) > 1
            ? "\n  " . $this->makeParametersDDL("\n  ") . "\n"
            : $this->makeParametersDDL();
        $procedureSignature = "PROCEDURE {$procedureName} ({$paramsDDL})";

        $createDDL = 'CREATE '
            . implode(
                "\n",
                array_filter(
                    [
                        (!empty($this->definer)) ? 'DEFINER = ' . $this->definer : null,
                        $procedureSignature,
                        $this->makeCharacteristicsDDL(),
                        'BEGIN',
                        $this->body,
                        'END' . $this->delimiter,
                    ]
                )
            );

        $createDDL = implode(
            "\n",
            array_filter(
                [
                    $setSqlMode,
                    $dropDDL,
                    $createDDL,
                    $revertSqlMode,
                ]
            )
        );

        return $createDDL;
    }

    public function __toString()
    {
        return $this->getCreateStatement();
    }

    /**
     * Make the portion of DDL for describing the parameters.
     *
     * @param string $separator string to apply between parameters
     *
     * @return string parameters DDL
     */
    protected function makeParametersDDL($separator = ' ')
    {
        $params = [];

        foreach ($this->parameters as $parameter) {
            $params[] = $parameter->getDDL();
        }

        return implode(',' . $separator, $params);
    }
}
