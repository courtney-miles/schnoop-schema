<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\Exception\FQNException;

class RoutineFunction extends AbstractRoutine implements RoutineFunctionInterface
{
    /**
     * Function parameters.
     * @var FunctionParameterInterface[]
     */
    protected $parameters = [];

    /**
     * Function return type.
     * @var DataTypeInterface
     */
    protected $returns;

    /**
     * RoutineFunction constructor.
     * @param string $name Function name.
     * @param DataTypeInterface $return Function return type.
     */
    public function __construct($name, DataTypeInterface $return)
    {
        parent::__construct($name);

        $this->returns = $return;
    }

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
    public function addParameter(FunctionParameterInterface $parameter)
    {
        $this->parameters[] = $parameter;
    }

    /**
     * {@inheritdoc}
     */
    public function getReturns()
    {
        return $this->returns;
    }

    /**
     * {@inheritdoc}
     */
    public function setReturns(DataTypeInterface $returns)
    {
        $this->returns = $returns;
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
                case self::DDL_DROP_POLICY_DROP:
                    $dropDDL = <<<SQL
DROP FUNCTION {$functionName}{$this->ddlDelimiter}
SQL;
                    break;
                case self::DDL_DROP_POLICY_DROP_IF_EXISTS:
                    $dropDDL = <<<SQL
DROP FUNCTION IF EXISTS {$functionName}{$this->ddlDelimiter}
SQL;
                    break;
            }
        }

        if ($this->hasSqlMode()) {
            $setSqlMode = $this->sqlMode->getAssignStmt($this->ddlDelimiter);
            $revertSqlMode = $this->sqlMode->getRestoreStmt($this->ddlDelimiter);
        }

        $functionSignature = "FUNCTION {$functionName} ({$this->makeParametersDDL()})";

        $createDDL .= 'CREATE '
            . implode(
                "\n",
                array_filter(
                    [
                        (!empty($this->definer)) ? 'DEFINER = ' . $this->definer : null,
                        $functionSignature,
                        'RETURNS ' . (string)$this->returns,
                        $this->makeCharacteristicsDDL(),
                        'BEGIN',
                        $this->body,
                        'END' . $this->ddlDelimiter
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

    /**
     * Make the portion of DDL for describing the parameters.
     * @return string Parameters DDL.
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
