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


$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$redis->select(2);

// 无序记录
$key = 'test_h';
$redis->hSet($key, 1, 1);
$redis->hSet($key, 2, 2);
$redis->hGet($key, 1);
$a = $redis->hMGet($key, [1, 2]);
debug($a);

$redis->hGetAll($key);





// 对插入的值进行排序 （可用于排行榜计算）
$zKey = 'test_z';
$redis->zAdd($zKey, 123, 1);
$redis->zAdd($zKey, 124, 2);

// 获取长度
$redis->zCard($zKey);

// 获取具体数据
$redis->zRevRange($zKey, 0, -1, true);


// 加锁
function lock($key) {

}


$redis->close();


