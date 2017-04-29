<?php

namespace RTTA\Test;

use BaseModel;

class Test extends BaseModel
{
    /**
     * @var TestTwo
     */
    private $testTwo;

    /**
     * Test constructor.
     *
     * @param TestTwo $testTwo
     */
    public function __construct(TestTwo $testTwo)
    {
        $this->testTwo = $testTwo;
    }

    public function test()
    {
        return $this->testTwo->test();
    }
}