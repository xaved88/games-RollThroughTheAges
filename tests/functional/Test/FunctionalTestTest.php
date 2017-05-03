<?php
use PHPUnit\Framework\TestCase;
use RTTA\Test\Test;
use RTTA\Test\TestTwo;


require_once APP_ROOT_DIR . 'tests/functional/BaseFunctional.php';

class FunctionalTestTest extends BaseFunctional
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