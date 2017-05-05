<?php

namespace RTTA\TestsFunctional\Test;

use Jane\Base\BaseVO;
use RTTA\Service\Test;
use RTTA\Test\TestVO;
use RTTA\TestsFunctional\BaseFunctional;

class VOTest extends BaseFunctional
{
    public function testBasicVOCreated()
    {
        $serviceName   = Test::SERVICE_NAME;
        $serviceMethod = Test::METHOD_TEST_VO_CREATION;

        $voName = TestVO::class;
        $params = [$voName];
        $result = $this->makeServiceCall($serviceName, $serviceMethod, $params);

        $vo = BaseVO::_importNewVO($result);
        $this->assertTrue($vo instanceof BaseVO);
    }

    public function testVOContstructorFilling()
    {
        $serviceName   = Test::SERVICE_NAME;
        $serviceMethod = Test::METHOD_TEST_VO_CONSTRUCTOR;

        $data = ['yo' => 'hi'];

        // When you can handle exceptions and error responses and all, you really should do the below as well
        //$data = ['yo' => 'hi', 'breakme' => 'wtf'];

        $params = [$data];
        $result = $this->makeServiceCall($serviceName, $serviceMethod, $params);
        $vo = BaseVO::_importNewVO($result);

        $this->assertTrue($vo instanceof BaseVO);
    }
}