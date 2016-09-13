<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Routine;

use MilesAsylum\SchnoopSchema\MySQL\Routine\AbstractRoutine;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\RoutineTestCase;

class AbstractRoutineTest extends RoutineTestCase
{
    protected $name = 'routine_name';
    /**
     * @var AbstractRoutine
     */
    protected $routine;

    public function setUp()
    {
        parent::setUp();

        $this->routine = $this->createRoutine();
    }

    public function getRoutine()
    {
        return $this->routine;
    }

    public function createRoutine()
    {
        return $this->getMockForAbstractClass(AbstractRoutine::class, [$this->name]);
    }

    public function getExpectedName()
    {
        return $this->name;
    }
}
