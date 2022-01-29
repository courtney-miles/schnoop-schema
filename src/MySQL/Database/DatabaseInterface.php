<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL\Database;

use MilesAsylum\SchnoopSchema\MySQL\CreateStatementInterface;
use MilesAsylum\SchnoopSchema\MySQL\DroppableInterface;
use MilesAsylum\SchnoopSchema\MySQL\HasDelimiterInterface;
use MilesAsylum\SchnoopSchema\MySQL\MySQLInterface;

interface DatabaseInterface extends MySQLInterface, HasDelimiterInterface, DroppableInterface, CreateStatementInterface
{
    /**
     * Get the database name.
     *
     * @return string the database name
     */
    public function getName();

    /**
     * Get the default collation for the database;.
     *
     * @return string the default collation
     */
    public function getDefaultCollation();

    /**
     * Identify if a default collation has been set.
     *
     * @return bool true if the default collation is set
     */
    public function hasDefaultCollation();

    /**
     * Set the default collation for the database.
     *
     * @param string $defaultCollation
     */
    public function setDefaultCollation($defaultCollation);

    /**
     * The DDL statement for the database;.
     *
     * @uses DatabaseInterface::getCreateStatement();
     *
     * @return string create DDL statement for the database
     */
    public function __toString();
}
