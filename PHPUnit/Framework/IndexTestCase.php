<?php

namespace MilesAsylum\SchnoopSchema\PHPUnit\Framework;

use MilesAsylum\SchnoopSchema\MySQL\Constraint\IndexInterface;
use MilesAsylum\SchnoopSchema\MySQL\Table\TableInterface;

abstract class IndexTestCase extends ConstraintTestCase
{
    abstract protected function getIndexType();

    /**
     * @return IndexInterface
     */
    abstract protected function getIndex();

    protected function getConstraint()
    {
        return $this->getIndex();
    }

    public function testInitialProperties()
    {
        parent::testInitialProperties();

        $index = $this->getIndex();

        $this->assertSame($this->getIndexType(), $index->getIndexType(), 'Assertion on ' . get_class($index));

        $this->assertFalse($index->hasComment(), 'Assertion on ' . get_class($index));
        $this->assertNull($index->getComment(), 'Assertion on ' . get_class($index));
    }

    public function testSetComment()
    {
        $comment = 'Schnoop comment';
        $index = $this->getIndex();
        $index->setComment($comment);

        $this->assertTrue($index->hasComment(), 'Assertion on ' . get_class($index));
        $this->assertSame($comment, $index->getComment(), 'Assertion on ' . get_class($index));
    }
}
