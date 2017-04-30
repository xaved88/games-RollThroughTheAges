<?php
use PHPUnit\Framework\TestCase;
use RTTA\Test\Test;
use RTTA\Test\TestTwo;

class GameTest extends TestCase
{
    public function testThis()
    {
        $testTwo = $this->createMock(TestTwo::class);
        $testConfigValue = 'we be testing';
        $subject = new Test($testTwo,$testConfigValue);

        $value = "whaoeutaoeu";

        $testTwo->expects($this->exactly(1))
            ->method('test')
            ->willReturn($value);

        $actual = $subject->test();

        $this->assertEquals($value,$actual);
    }
}