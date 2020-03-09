<?php
require_once 'BaseDatabase.php';

// Dao （data access object） 数据访问对象基类
abstract class BaseDao {
    protected $tableName;
    protected $db;
    protected $fields;

    public $where;
    protected $limit;
    protected $order;

    public $config = array(
        'host' => 'localhost',
        'port' => '3306',
        'user' => 'root',
        'password' => 'Summer@7171wan.com',
        'name' => 'blog',
    );

    public function __construct($tableName) {
        $this->tableName = $tableName;
        $this->db = new BaseDatabase($this->config);
    }

    // 增加
    public function insert($add) {
        if (empty($add)) return false;
        $fields = '';
        $values = '';
        foreach ($add as $key=> $value){
            $fields .= "`$key`,";
            $values .= "'$value',";
        }
        $fields = trim($fields, ',');
        $values = trim($values, ',');

        $sql = "INSERT INTO ";
        $sql .= "$this->tableName ($fields) values ($values)";
        $this->db->query($sql);

        return $this->db->insertId();
    }

    // 删除
    public function delete($conditions) {
        if (empty($conditions)) {
            return false;
        }
        $sql = "DELETE FROM $this->tableName";

        $this->where($conditions);

        if (is_null($this->where)) return false;
        $sql .= $this->where;
        $this->db->query($sql);
        return true;
    }

    // 修改
    public function updateWhere($update, $conditions, $limit = 1) {
        if ( empty($update) ) return false;

        $setFields = '';
        foreach($update as $key => $val) {
            if (is_array($val)) { //非数组, 表示这是正常的值, 用?做占位
                break;
            }
            $setFields .= "`$key` = '$val',";
        }

        if (empty($setFields)) {
            return false;
        }

        $setFields = trim($setFields, ',');
        $sql = "UPDATE $this->tableName set $setFields";
        if (!empty($conditions)) {
            $where = '';
            foreach ($conditions as $k => $condition) {
                $where .= " `$k` = '$condition' AND";
            }

            $sql .= ' where';
            $where = trim($where, 'AND');
            $sql .= $where;
        }

        if (!is_null($limit)) {
            $sql .= "LIMIT $limit";
        }
        $this->db->query($sql);
        return $this->db->affectRows();
    }

    // 查询
    public function fetch($conditions, $fields = '*') {
        $this->fields($fields);
        $sql = "SELECT $this->fields FROM $this->tableName";

        $this->where($conditions);
        if (is_null($this->where)) return false;
        $sql .= $this->where;

        $this->limit(1);
        $sql .= $this->limit;
        return $this->db->fetchRow($sql);
    }

    // 查询所有
    public function fetchAll($conditions, $rows = 0, $start = 0, $order = '', $fields = '*', $idSort = false) {
        $this->fields($fields);
        $sql = "SELECT $this->fields FROM $this->tableName";

        $this->where($conditions);
        if (is_null($this->where)) return false;
        $sql .= $this->where;

        $this->limit($rows, $start);
        $sql .= $this->limit;

        $this->orderBy($order);
        $sql .= $this->order;

        $sql = $this->db->escape_sql($sql);
        var_dump($sql);
        return $this->db->fetchArray($sql, $idSort);
    }

    // 获取数据条数
    public function count($conditions, $distinctFields = false) {
        $fields = $distinctFields ? "count(DISTINCT $distinctFields)" : 'count(*)';
        $this->fields($fields);
        $sql = "SELECT $this->fields as `num` FROM $this->tableName";

        $this->where($conditions);
        if (is_null($this->where)) return false;
        $sql .= $this->where;

        $row = $this->db->fetchRow($sql);
        return !empty($row) ? $row['num'] : 0;
    }

    // 是否存在
    public function exists($conditions, $distinctFields = false) {
        $num = $this->count($conditions, $distinctFields);
        return ($num > 0) ? true : false;
    }

    // 设置查询字段
    public function fields($fields) {
        if (is_array($fields)) {
            $this->fields = implode(',', $fields);
        } else {
            $this->fields = $fields;
        }
    }

    // 设置条件语句
    public function where($conditions) {
        if (empty($conditions)) {
            return;
        }
        $where = ' WHERE';
        foreach ($conditions as $k => $condition) {
            $condition = addslashes($condition);
            $where .= " `$k` = '$condition' AND";
        }
        $this->where = trim($where, 'AND');
    }

    // 设置查询条目
    public function limit($rows = 0, $start = 0) {
        if ($rows != 0) {
            $this->limit = " LIMIT $start, $rows";
        } else {
            $this->limit = '';
        }
    }

    // 设置查询顺序
    public function orderBy($order) {
        $this->order = 'ORDER BY '.$order;
    }
}