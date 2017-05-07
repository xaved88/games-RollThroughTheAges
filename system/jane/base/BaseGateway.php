<?php

namespace Jane\Base;

abstract class BaseGateway{

    protected $db;


    public function setDB($db){
        $this->db = $db;
    }
}