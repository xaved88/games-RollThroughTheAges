<?php

namespace Jane;

use PHPUnit\Framework\Exception;
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
    private $services;

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
        $this->services = [];
        $this->autoloadDirectory(APP_SYSTEM_DIR, ['php']);
        $this->autoloadDirectory(APP_INCLUDES_DIR, ['php']);
        $this->loadConfigs();
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
                            throw new \Exception("Error - class $type doesn't exist");
                        }
                        $paramObjects[] = $this->getService($type);
                    }
                }

                $this->services[$serviceName] = new $serviceName(...$paramObjects);
            } catch (ReflectionException $exception) {
                $this->services[$serviceName] = new $serviceName();
            }
        }

        return $this->services[$serviceName];
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