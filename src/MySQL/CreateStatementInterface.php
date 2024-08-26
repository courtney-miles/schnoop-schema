<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\MySQL;

interface CreateStatementInterface
{
    /**
     * Get the DDL statement/s to create the resource.
     */
    public function getCreateStatement();
}
