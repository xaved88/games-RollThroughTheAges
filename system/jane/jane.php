<?php

namespace Jane;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionException;
use ReflectionMethod;
use Test\TestTwo;

class Jane
{

    /**
     * @var mixed[]
     */
    private $services;


    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $this->services = [];
        $this->autoloadDirectory(APP_SYSTEM_DIR);
        $this->autoloadDirectory(APP_INCLUDES_DIR);
    }

    /**
     * @param string $serviceName
     *
     * @return mixed
     * @throws \Exception
     */
    public function getService(string $serviceName)
    {
        if (!isset($this->services[$serviceName])) {
            try {
                $reflectedConstructor = new ReflectionMethod($serviceName, "__construct");
                $reflectedParams      = $reflectedConstructor->getParameters();
                $paramObjects         = [];
                foreach ($reflectedParams as $param) {
                    $type = $param->getType();
                    if (!class_exists($type)) {
                        throw new \Exception("Error - class $type doesn't exist");
                    }
                    $paramObjects [] = $this->getService($type);
                }

                $this->services[$serviceName] = new $serviceName(...$paramObjects);
            } catch(ReflectionException $exception){
                $this->services[$serviceName] = new $serviceName();
            }
        }

        return $this->services[$serviceName];
    }

    /**
     * @param string $directory
     */
    private function autoloadDirectory(string $directory)
    {
        $directoryIterator    = new RecursiveDirectoryIterator($directory);
        $autoIncludeFileTypes = ['php'];
        foreach (new RecursiveIteratorIterator($directoryIterator) as $file) {
            $parts     = explode('.', $file);
            $extension = array_pop($parts);
            if (in_array(strtolower($extension), $autoIncludeFileTypes)) {
                include_once($file);
            }
        }
    }
}