<?php

namespace Jane;

use PDO;

class JanePDO
{
    public $db;

    public function makePDO($configData){

        llog('in makePDO');

         $dns = $configData['db_driver'] .
        ':host=' . $configData['db_host'] .
        ((!empty($configData['db_port'])) ? (';port=' . $configData['db_port']) : '') .
        ';dbname=' . $configData['db_name'];

        $username = $configData['db_user'];
        $password = $configData['db_pass'];
        $options = [];
        $this->db = new PDO($dns,$username,$password,$options);

        llog($this->db,3);
    }

}