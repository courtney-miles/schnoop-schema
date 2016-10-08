<?php

namespace MilesAsylum\SchnoopSchema\MySQL;

interface CreateStatementInterface
{
    /**
     * Get the DDL statement/s to create the resource.
     * @return mixed
     */
    public function getCreateStatement();
}
