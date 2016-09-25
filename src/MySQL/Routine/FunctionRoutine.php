<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\DataType\DataTypeInterface;
use MilesAsylum\SchnoopSchema\MySQL\Exception\ForceSqlModeException;
use MilesAsylum\SchnoopSchema\MySQL\Exception\FQNException;

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
DROP FUNCTION {$functionName}{$delimiter}
SQL;
                    break;
                case self::DDL_DROP_IF_EXISTS:
                    $dropDDL = <<<SQL
DROP FUNCTION IF EXISTS {$functionName}{$delimiter}
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

        $functionSignature = "FUNCTION {$functionName} ({$this->getParametersDDL()})";

        $createDDL .= 'CREATE '
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
                        'END' . $delimiter
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
