<?php
require_once 'BaseDao.php';
require_once 'redis.php';

class Dao extends BaseDao {
    public $info = array();
    public $_update = false;
    public $conditions = array();
    public $cache;

    public function __construct($tableName) {
        parent::__construct($tableName);
        $this->cache = new LdRedis('127.0.0.1');

        $info = $this->cache->get($this->getKey());
        if ($info == false) {
            $data = $this->fetch(['id' => 1]);
            if ($data == false) {
                $this->info = array();
                return;
            }

            $this->info = $data;
            $this->cache->set($this->getKey(), json_encode($data));
        } else {
            $this->info = json_decode($info, true);
        }
    }

    // 添加
    public function add($add) {
        $add['id'] = $this->insert($add);
        $this->info = $add;
        $this->cache->set($this->getKey(), $this->info);
    }

    // 更新
    public function update($update, $conditions = null, $is_update = true) {
        if (empty($this->info)) {
            return false;
        }

        foreach ($update as $k => $v) {
            $this->info[$k] = $v;
        }

        if (!$is_update) {
            $this->save();
        } else {
            $this->setConditions($conditions);
            $this->updateWhere($update, $this->conditions);
        }
        return true;
    }

    // 异步更新
    public function sync() {
        $info = $this->info;
        if (!is_array($info)) return false;
        if ($this->_update == false) return false;

        if (empty($this->conditions)) {
            $this->setConditions();
        }

        unset($info['id']);
        unset($info['uid']);

        $this->updateWhere($info, $this->conditions);
        return true;
    }

    // 设置条件
    public function setConditions($conditions = null) {
        if (is_null($conditions)) {
            $this->conditions = $conditions;
        }

        if (isset($this->info['id'])) {
            $this->conditions = ['id' => $this->info['id']];
        } else {
            $this->conditions = ['uid' => $this->info['uid']];
        }
    }

    // 更新
    public function save() {
        $this->_update = true;
    }

    // 手动更新数据
    public function destroy() {
        $this->sync();
        $this->cache->set($this->getKey(), json_encode($this->info));
    }

    public function __destruct() {
        $this->destroy();
    }

    // 获取键
    public function getKey() {
        return $this->tableName.'_dao';
    }
}