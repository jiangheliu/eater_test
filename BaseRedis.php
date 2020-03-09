<?php
require_once 'redis.php';

class BaseRedis extends LdRedis {
    public function __construct($host = '127.0.0.1', $port = 6379, $timeout = 0.0, $password = '') {
        parent::__construct($host, $port, $timeout, $password);
        $this->select(2);
    }
}