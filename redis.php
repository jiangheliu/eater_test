<?php
/*
+-------------------------------------------------------------------------------
| Author: lzp
+-------------------------------------------------------------------------------
*/
require 'code.php';

class LdRedis extends Redis {
    public function __construct($host, $port = 6379, $timeout = 0.0, $password = '') {
        parent::__construct();

        $this->connect($host, $port, floor($timeout));

        if (!empty($password)) {
            $this->auth($password);
        }
    }
}



