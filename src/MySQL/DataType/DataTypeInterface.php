<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 19/06/16
 * Time: 4:01 PM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

interface DataTypeInterface extends \MilesAsylum\SchnoopSchema\DataTypeInterface
{
    const TYPE_BOOL = 'bool';

    const TYPE_BIT = 'bit';

    const TYPE_INT = 'int';
    const TYPE_TINYINT = 'tinyint';
    const TYPE_SMALLINT = 'smallint';
    const TYPE_MEDIUMINT = 'mediumint';
    const TYPE_BIGINT = 'bigint';

    const TYPE_DECIMAL = 'decimal';
    const TYPE_NUMERIC = 'numeric';

    const TYPE_FLOAT = 'float';
    const TYPE_DOUBLE = 'double';

    const TYPE_CHAR = 'char';
    const TYPE_VARCHAR = 'varchar';

    const TYPE_TEXT = 'text';
    const TYPE_TINYTEXT = 'tinytext';
    const TYPE_MEDIUMTEXT = 'mediumtext';
    const TYPE_LONGTEXT = 'longtext';

    const TYPE_BINARY = 'binary';
    const TYPE_VARBINARY = 'varbinary';

    const TYPE_BLOB = 'blob';
    const TYPE_TINYBLOB = 'tinyblob';
    const TYPE_MEDIUMBLOB = 'mediumblob';
    const TYPE_LONGBLOB = 'longblob';

    const TYPE_ENUM = 'enum';
    const TYPE_SET = 'set';

    const TYPE_DATE = 'date';
    const TYPE_DATETIME = 'datetime';
    const TYPE_TIMESTAMP = 'timestamp';
    const TYPE_TIME = 'time';
    const TYPE_YEAR = 'year';

    /**
     * @return bool
     */
    public function doesAllowDefault();

    /**
     * Cast a value from MySQL to a suitable PHP type.
     * @param mixed $value
     * @return mixed
     */
    public function cast($value);

    /**
     * Quotes a value, based on the type, for use in a DDL statement. Do not believe for a second that this will make queries safe.
     * @param $value
     * @return mixed
     */
    public function quote($value);
}
