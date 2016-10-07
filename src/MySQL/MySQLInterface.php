<?php

namespace MilesAsylum\SchnoopSchema\MySQL;

interface MySQLInterface
{
    const DEFINER_CURRENT_USER = 'CURRENT_USER';

    const DEFAULT_DELIMITER = ';';

    /**
     * Indicates that the DDL for a resource will not include a drop statement
     */
    const DDL_DROP_DO_NOT = 0;

    /**
     * Indicates that the DDL for a resource will include a statement to first drop it if it exists.
     */
    const DDL_DROP_IF_EXISTS = 1;

    /**
     * Indicates that the DDL for a resource will include a statement to drop it with expectation that it will exist.
     */
    const DDL_DROP_DOES_EXISTS = 2;
}
