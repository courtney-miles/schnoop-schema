<?php

namespace MilesAsylum\SchnoopSchema\MySQL;

interface DroppableInterface
{
    /**
     * Indicates that the DDL for a resource will not include a drop statement
     */
    const DDL_DROP_POLICY_DO_NOT_DROP = 0;

    /**
     * Indicates that the DDL for a resource will include a statement to first drop it if it exists.
     */
    const DDL_DROP_POLICY_DROP_IF_EXISTS = 1;

    /**
     * Indicates that the DDL for a resource will include a statement to drop it with expectation that it will exist.
     */
    const DDL_DROP_POLICY_DROP = 2;

    public function getDropPolicy();

    public function setDropPolicy($dropPolicy);
}
