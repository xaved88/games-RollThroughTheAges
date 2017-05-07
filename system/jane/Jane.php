<?php

namespace Jane;

use Exception;

require APP_JANE_DIR . 'JaneAutoloader.php';

class Jane
{
    /**
     * @var mixed[]
     */
    private $components;

    /**
     * @var mixed[];
     */
    private $values;
    /**
     * @var JaneAutoloader
     */
    private $autoloader;

    /**
     * @var JaneComponentFetcher
     */
    private $componentFetcher;

    public function __construct()
    {
        $this->initAutoloader();
        $this->initComponentFetcher();
        $this->initPDO(); // WHERE SHOULD THIS GO AND BE? THE COMPONENT MANAGER NEEDS IT.... BUT I WANT TO USE THE AUTO CONFIG HERE TOO
    }

    public function callService($path, $params)
    {
        $pathPieces = explode('/', $path);

        if ($pathPieces[0] != "api") {
            throw new Exception("I don't know what to do with a call that isn't for the api!");
        }

        $serviceName = $pathPieces[1];
        $methodName  = $pathPieces[2];

        $fullServiceName = APP_PROJECT_NAMESPACE . '\\' . APP_SERVICE_NAMESPACE . '\\' . $serviceName;
        if (!class_exists($fullServiceName)) {
            throw new Exception("Error - service $fullServiceName doesn't exist");
        }

        $service = $this->componentFetcher->getComponent($fullServiceName);

        if (!method_exists($service, $methodName)) {
            throw new Exception("Method call to $serviceName :: $methodName - method doesn't exist");
        }

        $ret = $service->$methodName(...$params);

        return json_encode($ret);
    }

    private function initAutoloader()
    {
        $this->components = [];
        $this->autoloader = new JaneAutoloader();
        $this->autoloader->initiateAutoloadRegistry();
        $this->values = $this->autoloader->loadConfigs();
    }

    private function initComponentFetcher()
    {
        $this->componentFetcher = new JaneComponentFetcher($this->autoloader);
    }

    private function initPDO()
    {
        $this->pdo = new JanePDO();


        $configData              = [];
        $configData['db_driver'] = $this->componentFetcher->getValue('config.db.db_driver');
        $configData['db_host']   = $this->componentFetcher->getValue('config.db.db_host');
        $configData['db_name']   = $this->componentFetcher->getValue('config.db.db_name');
        $configData['db_user']   = $this->componentFetcher->getValue('config.db.db_user');
        $configData['db_pass']   = $this->componentFetcher->getValue('config.db.db_pass');

        $this->pdo->makePDO($configData);

        $db = 'wtf';

        $this->componentFetcher->setDB($db);
    }
}