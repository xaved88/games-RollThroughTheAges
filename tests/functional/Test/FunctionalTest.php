<?php

namespace RTTA\TestsFunctional\Test;

use RTTA\TestsFunctional\BaseFunctional;

class FunctionalTest extends BaseFunctional
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