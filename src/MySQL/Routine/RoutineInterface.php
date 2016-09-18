<?php
namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\SetVar\SqlMode;

interface RoutineInterface
{
    const DEFINER_CURRENT_USER = 'CURRENT_USER';

    const DATA_ACCESS_CONTAINS_SQL = 'CONTAINS SQL';

    const DATA_ACCESS_NO_SQL = 'NO SQL';

    const DATA_ACCESS_READS_SQL_DATA = 'READS SQL DATA';

    const DATA_ACCESS_MODIFIES_SQL_DATA = 'MODIFIES SQL DATA';

    const SECURITY_DEFINER = 'DEFINER';

    const SECURITY_INVOKER = 'INVOKER';

    public function getName();

    public function getDatabaseName();

    public function hasDatabaseName();

    public function setDatabaseName($databaseName);

    /**
     * @return mixed
     */
    public function getDefiner();

    /**
     * @param mixed $definer
     */
    public function setDefiner($definer);

    /**
     * @return mixed
     */
    public function getComment();

    /**
     * @param mixed $comment
     */
    public function setComment($comment);

    public function hasComment();

    /**
     * @return boolean
     */
    public function isDeterministic();

    /**
     * @param boolean $deterministic
     */
    public function setDeterministic($deterministic);

    /**
     * @return mixed
     */
    public function getDataAccess();

    /**
     * @param mixed $contains
     */
    public function setDataAccess($contains);

    /**
     * @return mixed
     */
    public function getSqlSecurity();

    /**
     * @param mixed $sqlSecurity
     */
    public function setSqlSecurity($sqlSecurity);

    /**
     * @return mixed
     */
    public function getBody();

    /**
     * @param mixed $body
     */
    public function setBody($body);

    /**
     * @return SqlMode
     */
    public function getSqlMode();

    /**
     * @return bool
     */
    public function hasSqlMode();

    /**
     * @param SqlMode $sqlMode
     */
    public function setSqlMode(SqlMode $sqlMode);

    /**
     * @return string
     */
    public function __toString();
}
