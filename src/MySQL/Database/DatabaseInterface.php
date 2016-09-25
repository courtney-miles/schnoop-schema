<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 27/06/16
 * Time: 7:20 AM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\Database;

use MilesAsylum\SchnoopSchema\MySQL\MySQLInterface;

interface DatabaseInterface extends MySQLInterface
{
    public function getName();

    public function getDefaultCollation();

    public function hasDefaultCollation();

    public function setDefaultCollation($defaultCollation);

    public function getDDL(
        $delimiter = self::DEFAULT_DELIMITER,
        $drop = self::DDL_DROP_DO_NOT
    );

    public function __toString();
}
