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
     * @var string
     */
    private $configValue;
    /**
     * @var string
     */
    private $dataValue;

    /**
     * @param TestTwo $testTwo
     * @param string  $configValue @value config.test.testValue
     * @param array  $dataValue   @value data.test.test
     */
    public function __construct(TestTwo $testTwo, string $configValue, array $dataValue)
    {
        $this->testTwo     = $testTwo;
        $this->configValue = $configValue;
        $this->dataValue   = $dataValue;
    }

    /**
     * @return string
     */
    public function test()
    {
        return $this->testTwo->test();
    }

    /**
     * @return string
     */
    public function getConfigValue()
    {
        return $this->configValue;
    }

    /**
     * @return string
     */
    public function getDataValue()
    {
        return $this->dataValue;
    }
}