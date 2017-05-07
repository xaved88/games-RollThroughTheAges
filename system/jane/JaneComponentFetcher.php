<?php

namespace Jane;

use Exception;
use Jane\Base\BaseGateway;
use ReflectionException;
use ReflectionMethod;

class JaneComponentFetcher
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

    /**
     * @var JaneAutoloader
     */
    private $autoloader;
    /**
     * @var JanePDO
     */
    private $db;

    /**
     * @param JaneAutoloader $autoloader
     */
    public function __construct(JaneAutoloader $autoloader)
    {
        $this->autoloader = $autoloader;
        $this->values     = $this->autoloader->loadConfigs();
    }

    public function setDB($db)
    {
        $this->db = $db;
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

            if ($this->components[$componentName] instanceof BaseGateway) {
                $this->components[$componentName]->setPDO($this->db);
            }
        }

        return $this->components[$componentName];
    }

    /**
     * @param string $key
     *
     * @return mixed
     * @throws Exception
     */
    public function getValue(string $key)
    {
        if (!isset($this->values[$key])) {

            $parts = explode('.', $key);

            if ('data' === array_shift($parts)) {
                $filePath           = implode("/", $parts) . ".php";
                $this->values[$key] = include APP_DATA_DIR . $filePath;
            } else {
                throw new Exception("Config, Data, or other injected value not defined: $key");
            }
        }

        return $this->values[$key];

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
}