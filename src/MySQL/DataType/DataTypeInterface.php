<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 19/06/16
 * Time: 4:01 PM.
 */

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

use MilesAsylum\SchnoopSchema\MySQL\MySQLInterface;

interface DataTypeInterface extends MySQLInterface
{
    public const TYPE_BIT = 'bit';

    public const TYPE_INT = 'int';
    public const TYPE_TINYINT = 'tinyint';
    public const TYPE_SMALLINT = 'smallint';
    public const TYPE_MEDIUMINT = 'mediumint';
    public const TYPE_BIGINT = 'bigint';

    public const TYPE_DECIMAL = 'decimal';
    public const TYPE_NUMERIC = 'numeric';

    public const TYPE_FLOAT = 'float';
    public const TYPE_DOUBLE = 'double';

    public const TYPE_CHAR = 'char';
    public const TYPE_VARCHAR = 'varchar';

    public const TYPE_TEXT = 'text';
    public const TYPE_TINYTEXT = 'tinytext';
    public const TYPE_MEDIUMTEXT = 'mediumtext';
    public const TYPE_LONGTEXT = 'longtext';

    public const TYPE_JSON = 'json';

    public const TYPE_BINARY = 'binary';
    public const TYPE_VARBINARY = 'varbinary';

    public const TYPE_BLOB = 'blob';
    public const TYPE_TINYBLOB = 'tinyblob';
    public const TYPE_MEDIUMBLOB = 'mediumblob';
    public const TYPE_LONGBLOB = 'longblob';

    public const TYPE_ENUM = 'enum';
    public const TYPE_SET = 'set';

    public const TYPE_DATE = 'date';
    public const TYPE_DATETIME = 'datetime';
    public const TYPE_TIMESTAMP = 'timestamp';
    public const TYPE_TIME = 'time';
    public const TYPE_YEAR = 'year';

    /**
     * Get the data type name.
     *
     * @return string Data type name.  One of the self::TYPE_* constants.
     */
    public function getType();

    /**
     * Identify if the type allows a default value.
     *
     * @return bool true if the type allows a default
     */
    public function doesAllowDefault();

    /**
     * Cast a value from MySQL to a suitable PHP type.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function cast($value);

    /**
     * Quotes a value, based on the type, for use in a DDL statement. Do not
     * believe for a second that this will make your queries safe from
     * injection exploits.
     *
     * @param string|float|int $value The value to quote. If you are passing
     *                                a number and you need it quoted, cast it to a string.
     *
     * @return mixed
     */
    public function quote($value);

    /**
     * Get the portion of DDL for describing the data type.
     *
     * @return string
     */
    public function getDDL();

    /**
     * The portion of DDL for describing the data type.
     *
     * @uses DataTypeInterface::getDDL()
     *
     * @return string
     */
    public function __toString();
}
