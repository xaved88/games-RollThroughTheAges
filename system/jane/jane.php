<?php

namespace Jane;

use Exception;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionException;
use ReflectionMethod;

class Jane
{
    const VALUE_DOCBLOCK_TRIGGER = '@value';
    const VALUE_DOCBLOCK_PATTERN = '#\$([\w]+)\s+@value\s+([\w._]+)#';

    /**
     * @var mixed[]
     */
    private $components;

    /**
     * @var mixed[];
     */
    private $values;

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $this->components = [];
        $this->autoloadDirectory(APP_SYSTEM_DIR, ['php']);
        $this->autoloadDirectory(APP_INCLUDES_DIR, ['php']);
        $this->loadConfigs();
    }

    public function callService($path, $params)
    {
        $pathPieces = explode('/', $path);

        if ($pathPieces[0] != "api") {
            throw new Exception("I don't know what to do with a call that isn't for the api!");
        }

        $serviceName = $pathPieces[1];
        $methodName  = $pathPieces[2];

        $this->autoloadDirectory(APP_SERVICE_DIR, ['php']);

        $fullServiceName = SERVICE_NAMESPACE . '\\' . $serviceName;
        if (!class_exists($fullServiceName)) {
            throw new Exception("Error - service $fullServiceName doesn't exist");
        }

        $service = $this->getComponent($fullServiceName);
        if(!method_exists($service,$methodName)){
            throw new Exception("Method call to $serviceName :: $methodName - method doesn't exist");
        }

        $ret = $service->$methodName(...$params);
        return $ret;

    }

    /**
     * @param string $componentName
     *
     * @return mixed
     * @throws \Exception
     */
    public function getComponent(string $componentName)
    {
        if (!isset($this->components[$componentName])) {
            try {
                $reflectedConstructor = new ReflectionMethod($componentName, "__construct");
                $docBlock             = $reflectedConstructor->getDocComment();
                $values               = $this->parseInjectedValues($docBlock);

                $reflectedParams = $reflectedConstructor->getParameters();
                $paramObjects    = [];
                foreach ($reflectedParams as $param) {
                    $type = $param->getType();
                    $name = $param->getName();

                    if (isset($values[$name])) {
                        $paramObjects[] = $this->getValue($values[$name]);
                    } else {
                        if (!class_exists($type)) {
                            throw new Exception("Error - class $type doesn't exist");
                        }
                        $paramObjects[] = $this->getComponent($type);
                    }
                }

                $this->components[$componentName] = new $componentName(...$paramObjects);
            } catch (ReflectionException $exception) {
                $this->components[$componentName] = new $componentName();
            }
        }

        return $this->components[$componentName];
    }

    /**
     * @param string $comment
     *
     * @return array
     */
    private function parseInjectedValues(string $comment): array
    {
        if (strpos($comment, static::VALUE_DOCBLOCK_TRIGGER) === -1) {
            return [];
        }
        preg_match_all(static::VALUE_DOCBLOCK_PATTERN, $comment, $valueMatches);

        if (empty($valueMatches)) {
            return [];
        }

        $numberOfMatches = count($valueMatches[0]);

        $parsedValueKeys = [];
        for ($i = 0; $i < $numberOfMatches; $i++) {
            $parsedValueKeys[$valueMatches[1][$i]] = $valueMatches[2][$i];
        }

        return $parsedValueKeys;
    }

    /**
     * @param string $directory
     * @param array  $fileTypes
     */
    private function autoloadDirectory(string $directory, array $fileTypes)
    {
        $files = $this->findFilesInDirectory($directory, $fileTypes);

        foreach ($files as $file) {
            include_once $file;
        }
    }

    /**
     * @param string $directory
     * @param array  $fileTypes
     *
     * @return array
     */
    private function findFilesInDirectory(string $directory, array $fileTypes)
    {
        $filesFound        = [];
        $directoryIterator = new RecursiveDirectoryIterator($directory);
        foreach (new RecursiveIteratorIterator($directoryIterator) as $file) {
            $parts     = explode('.', $file);
            $extension = array_pop($parts);
            if (in_array(strtolower($extension), $fileTypes)) {
                $filesFound[] = $file;
            }
        }

        return $filesFound;
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    private function getValue($key)
    {
        if (!isset($this->values[$key])) {

            $parts = explode('.', $key);

            if (array_shift($parts) === 'data') {
                $filePath           = implode("/", $parts) . ".php";
                $this->values[$key] = include APP_DATA_DIR . $filePath;
            } else {
                throw new Exception("Config, Data, or other injected value not defined: $key");
            }
        }

        return $this->values[$key];

    }

    private function loadConfigs()
    {
        $files        = $this->findFilesInDirectory(APP_CONFIG_DIR, ['ini']);
        $this->values = [];
        foreach ($files as $file) {
            $configName = $file->getFilename();
            $configName = substr($configName, 0, -4);

            $file     = file_get_contents($file->getPathname());
            $settings = parse_ini_string($file);
            foreach ($settings as $settingName => $settingValue) {
                $this->values["config." . $configName . "." . $settingName] = $settingValue;
            }
        }
    }
}