<?php
namespace MilesAsylum\SchnoopSchema\MySQL\Routine;

interface RoutineInterface
{
    const DEFINER_CURRENT_USER = 'CURRENT_USER';

    const CONTAINS_SQL = 'CONTAINS SQL';

    const CONTAINS_NO_SQL = 'NO SQL';

    const CONTAINS_READS_SQL_DATA = 'READS SQL DATA';

    const CONTAINS_MODIFIES_SQL_DATA = 'MODIFIES SQL DATA';

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
    public function getContains();

    /**
     * @param mixed $contains
     */
    public function setContains($contains);

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
     * @return string
     */
    public function __toString();
}
