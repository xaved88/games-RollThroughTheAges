<?php

namespace RTTA\Service;

use Jane\Base\BaseService;
use RTTA\Test\Test as TestModel;

class Test extends BaseService
{
    /**
     * @var TestModel
     */
    private $testModel;
    /**
     * @var string
     */
    private $configValue;
    /**
     * @var array
     */
    private $dataValue;

    /**
     * @param TestModel $testModel
     * @param string    $configValue @value config.test.testValue
     * @param array     $dataValue   @value data.test.test
     */
    public function __construct(TestModel $testModel, string $configValue, array $dataValue)
    {
        $this->testModel   = $testModel;
        $this->configValue = $configValue;
        $this->dataValue   = $dataValue;
    }


    public function testMethod($a,$b){
        return $this->testModel->testForTheServiceCall($a,$b);
    }
}