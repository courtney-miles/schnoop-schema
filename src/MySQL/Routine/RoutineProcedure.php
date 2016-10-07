<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\Exception\FQNException;

class RoutineProcedure extends AbstractRoutine implements RoutineProcedureInterface
{
    /**
     * Routine parameters.
     * @var ProcedureParameterInterface[]
     */
    protected $parameters = [];

    /**
     * {@inheritdoc}
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function hasParameters()
    {
        return !empty($this->parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function addParameter(ProcedureParameterInterface $parameter)
    {
        $this->parameters[] = $parameter;
    }

    /**
     * {@inheritdoc}
     */
    public function getDDL()
    {
        $dropDDL = $setSqlMode = $createDDL = $revertSqlMode = '';

        if ($this->ddlUseFullyQualifiedName) {
            if (!$this->hasDatabaseName()) {
                throw new FQNException(
                    'Unable to create DDL with fully-qualified-name because the database name has not been set.'
                );
            }

            $functionName = "`{$this->getDatabaseName()}`.`{$this->getName()}`";
        } else {
            $functionName = "`{$this->getName()}`";
        }

        if ($this->ddlDropPolicy) {
            switch ($this->ddlDropPolicy) {
                case self::DDL_DROP_DOES_EXISTS:
                    $dropDDL = <<<SQL
DROP PROCEDURE {$functionName}{$this->ddlDelimiter}
SQL;
                    break;
                case self::DDL_DROP_IF_EXISTS:
                    $dropDDL = <<<SQL
DROP PROCEDURE IF EXISTS {$functionName}{$this->ddlDelimiter}
SQL;
                    break;
            }
        }

        if ($this->hasSqlMode()) {
            $setSqlMode = $this->sqlMode->getAssignStmt($this->ddlDelimiter);
            $revertSqlMode = $this->sqlMode->getRestoreStmt($this->ddlDelimiter);
        }

        $procedureSignature = "PROCEDURE {$functionName} ({$this->makeParametersDDL()})";

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
                    $revertSqlMode,
                    $this->ddlDelimiter
                ]
            )
        );

        return $createDDL;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getDDL();
    }

    /**
     * {@inheritdoc}
     */
    protected function makeParametersDDL()
    {
        $params = [];

        foreach ($this->parameters as $parameter) {
            $params[] = (string)$parameter;
        }

        return implode(',', $params);
    }
}
