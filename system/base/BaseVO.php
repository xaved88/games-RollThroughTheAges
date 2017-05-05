<?php

namespace Jane\Base;

use Exception;

abstract class BaseVO
{
    /**
     * @var string
     */
    public $__className__;

    /**
     * @param mixed $data
     */
    public function __construct($data = null)
    {
        $this->__className__ = $this->getClassName();

        if (is_array($data)) {
            $this->_importFromRawData($data);
        } elseif (is_string($data)) {
            $this->_importFromJson($data);
        }
    }

    /**
     * @param array $data
     *
     * @throws Exception
     */
    public function _importFromRawData(array $data)
    {
        if (isset($data['__className__'])) {
            if ($data['__className__'] !== $this->__className__) {
                throw new Exception(sprintf('Trying to load import a VO but it isn\'t working'));
            }

            unset($data['__className__']);
        }

        foreach($data as $parameter => $value){
            if(property_exists($this,$parameter)) {
                $this->$parameter = $value;
            } else {
                throw new Exception ("Trying to add non-existent property to a VO");
            }
        }
    }

    /**
     * @param string $json
     */
    public function _importFromJson(string $json)
    {
        $this->_importFromRawData(json_decode($json, true));
    }

    private function getClassName()
    {
        return static::class;
    }

    /**
     * @param mixed $data
     *
     * @return BaseVO
     * @throws Exception
     */
    static public function _importNewVO($data): BaseVO
    {
        if(is_string($data)){
            $data = json_decode($data,true);
        }
        if(is_array($data) && !empty($data['__className__'])){
            return new $data['__className__']($data);
        }

        throw new Exception('trying to create a new VO but something isnt working');
    }

}