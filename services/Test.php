<?php

namespace RTTA\Service;

use Jane\Base\BaseService;
use Jane\Base\BaseVO;
use RTTA\Test\Test as TestModel;
use RTTA\Test\TestVO;

class Test extends BaseService
{

    const SERVICE_NAME               = 'Test';
    const METHOD_TEST_METHOD         = 'testMethod';
    const METHOD_TEST_VO_CREATION    = 'testVOCreation';
    const METHOD_TEST_VO_CONSTRUCTOR = 'testVOFillingInConstructor';

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


    public function testMethod($a, $b)
    {
        return $this->testModel->testForTheServiceCall($a, $b);
    }

    /**
     * @param string $voName
     *
     * @return mixed
     */
    public function testVOCreation(string $voName)
    {
        return new $voName();
    }

    /**
     * @param array $data
     *
     * @return TestVO
     */
    public function testVOFillingInConstructor(array $data)
    {
        return new TestVO($data);
    }
}