<?php
/**
 * Created by PhpStorm.
 * User: courtney
 * Date: 27/06/16
 * Time: 7:20 AM
 */

namespace MilesAsylum\SchnoopSchema\MySQL\Database;

interface DatabaseInterface
{
    public function getName();

    public function getDefaultCollation();

    public function hasDefaultCollation();

    public function setDefaultCollation($defaultCollation);

    public function __toString();
}
