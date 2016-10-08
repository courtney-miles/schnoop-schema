<?php

namespace MilesAsylum\SchnoopSchema\MySQL;

interface DDLStatementInterface
{
    /**
     * Get the DDL statement/s to create the resource.
     * @return mixed
     */
    public function getDDL();
}
