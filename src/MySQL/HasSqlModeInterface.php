<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL;

use MilesAsylum\SchnoopSchema\MySQL\SetVar\SqlMode;

interface HasSqlModeInterface
{
    /**
     * Gets the SQL mode for the resource.
     *
     * @return SqlMode
     */
    public function getSqlMode();

    /**
     * Set the SQL mode for the resource.
     */
    public function setSqlMode(SqlMode $sqlMode);

    /**
     * Identify if an SQL mode has been set for the resource.
     *
     * @return bool true if a mode has been set
     */
    public function hasSqlMode();

    /**
     * Unset the SQL mode for the resource. The mode of the resource will be
     * inherited from the connection at the time of creation.
     */
    public function unsetSqlMode();
}
