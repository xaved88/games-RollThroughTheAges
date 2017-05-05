<?php
namespace RTTA\TestsFunctional\Game;

use RTTA\TestsFunctional\BaseFunctional;

abstract class BaseGameTest extends BaseFunctional
{
    public function testThis()
    {
        $serviceName   = "Test";
        $serviceMethod = "testMethod";
        $params        = ['one', 'two'];
        $result        = $this->makeServiceCall($serviceName, $serviceMethod, $params);
        $this->assertEquals(implode('-', $params), $result);
    }
}