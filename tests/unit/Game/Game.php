<?php
use PHPUnit\Framework\TestCase;
use RTTA\Test\Test;
use RTTA\Test\TestTwo;

class GameTest extends TestCase
{
    public function testThis()
    {
        $testTwo = $this->createMock(TestTwo::class);

        $subject = new Test($testTwo);

        $value = "whaoeutaoeu";

        $testTwo
            ->method('test')
            ->willReturn($value);

        $actual = $subject->test();

        $this->assertEquals($value,$actual);
    }
}