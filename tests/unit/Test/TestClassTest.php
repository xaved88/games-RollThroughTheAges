<?php
use PHPUnit\Framework\TestCase;
use RTTA\Test\Test;
use RTTA\Test\TestTwo;

class TestClassTest extends TestCase
{
    public function testThis()
    {
        $testTwo = $this->createMock(TestTwo::class);
        $testConfigValue = 'we be testing';
        $testDataValue = ['abcdefg'];
        $subject = new Test($testTwo,$testConfigValue, $testDataValue);


        $value = "whaoeutaoeu";
        $testTwo->expects($this->once())
            ->method('test')
            ->willReturn($value);
        $actual = $subject->test();
        $this->assertEquals($value,$actual);

        $actualConfigValue = $subject->getConfigValue();
        $this->assertEquals($testConfigValue,$actualConfigValue);

        $actualDataValue = $subject->getDataValue();
        $this->assertEquals($testDataValue,$actualDataValue);
    }
}