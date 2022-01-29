<?php

declare(strict_types=1);

namespace MilesAsylum\SchnoopSchema\PHPUnit\Framework;

use MilesAsylum\SchnoopSchema\MySQL\Constraint\ConstraintInterface;

abstract class ConstraintTestCase extends SchnoopSchemaTestCase
{
    /**
     * @return ConstraintInterface
     */
    abstract protected function getConstraint();

    abstract protected function getConstraintName();

    abstract protected function getConstraintType();

    public function testInitialProperties(): void
    {
        $constraint = $this->getConstraint();

        $this->assertSame($this->getConstraintName(), $constraint->getName(), 'Assertion on ' . get_class($constraint));
        $this->assertSame(
            $this->getConstraintType(),
            $constraint->getConstraintType(),
            'Assertion on ' . get_class($constraint)
        );

        $this->assertFalse($constraint->hasTableName(), 'Assertion on ' . get_class($constraint));
        $this->assertNull($constraint->getTableName(), 'Assertion on ' . get_class($constraint));

        $this->assertFalse($constraint->hasDatabaseName(), 'Assertion on ' . get_class($constraint));
        $this->assertNull($constraint->getDatabaseName(), 'Assertion on ' . get_class($constraint));
    }

    public function testSetTableName(): void
    {
        $tableName = 'schnoop_tbl';
        $constraint = $this->getConstraint();
        $constraint->setTableName($tableName);

        $this->assertTrue($constraint->hasTableName(), 'Assertion on ' . get_class($constraint));
        $this->assertSame($tableName, $constraint->getTableName(), 'Assertion on ' . get_class($constraint));
    }

    public function testSetDatabaseName(): void
    {
        $databaseName = 'schnoop_db';
        $constraint = $this->getConstraint();
        $constraint->setDatabaseName($databaseName);

        $this->assertTrue($constraint->hasDatabaseName(), 'Assertion on ' . get_class($constraint));
        $this->assertSame($databaseName, $constraint->getDatabaseName(), 'Assertion on ' . get_class($constraint));
    }
}
