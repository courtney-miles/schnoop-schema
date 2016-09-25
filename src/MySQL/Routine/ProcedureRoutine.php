<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\Exception\ForceSqlModeException;
use MilesAsylum\SchnoopSchema\MySQL\Exception\FQNException;

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

    /**
     * {@inheritdoc}
     */
    public function getDDL(
        $forceSqlMode = false,
        $delimiter = self::DEFAULT_DELIMITER,
        $fullyQualifiedName = false,
        $drop = self::DDL_DROP_DO_NOT
    ) {
        $dropDDL = $setSqlMode = $createDDL = $revertSqlMode = '';

        if ($fullyQualifiedName) {
            if (!$this->hasDatabaseName()) {
                throw new FQNException(
                    'Unable to create DDL with fully-qualified-name because the database name has not been set.'
                );
            }

            $functionName = "`{$this->getDatabaseName()}`.`{$this->getName()}`";
        } else {
            $functionName = "`{$this->getName()}`";
        }

        if ($drop) {
            switch ($drop) {
                case self::DDL_DROP_ALWAYS:
                    $dropDDL = <<<SQL
DROP PROCEDURE {$functionName}{$delimiter}
SQL;
                    break;
                case self::DDL_DROP_IF_EXISTS:
                    $dropDDL = <<<SQL
DROP PROCEDURE IF EXISTS {$functionName}{$delimiter}
SQL;
                    break;
            }
        }

        if ($forceSqlMode) {
            if (!$this->hasSqlMode()) {
                throw new ForceSqlModeException(
                    'Unable to create DDL that forces the SQL mode because an SQL mode has not been set.'
                );
            }

            $setSqlMode = $this->sqlMode->getAssignStmt($delimiter);
            $revertSqlMode = $this->sqlMode->getRestoreStmt($delimiter);
        }

        $procedureSignature = "PROCEDURE {$functionName} ({$this->getParametersDDL()})";

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

        $createDDL = implode(
            "\n",
            array_filter(
                [
                    $dropDDL,
                    $setSqlMode,
                    $createDDL,
                    $revertSqlMode
                ]
            )
        );

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
