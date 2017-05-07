<?php

namespace RTTA\TestsFunctional\Test;

use RTTA\Service\Test;
use RTTA\TestsFunctional\BaseFunctional;

class DatabaseTest extends BaseFunctional
{
    public function testDBConnectionEstablished()
    {
        $result = $this->makeServiceCall(Test::SERVICE_NAME, Test::METHOD_TEST_DB_CONNECTION);

        $this->assertEquals($result,1);
    }
}