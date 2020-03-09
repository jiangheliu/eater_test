<?php
class BaseDatabase {
    protected $db;
    protected $config;

    public function __construct($config) {
        $this->config = $config;

        $this->db = mysqli_connect($config['host'], $config['user'], $config['password']);

        if (!$this->db) {
            $fileName = "mysqli_error_log_".date('Ymd').'log';
            $content = PHP_EOL. date('Y-m-d H:i:s'). PHP_EOL;
            $content .= mysqli_error($this->db).PHP_EOL;
            if (!file_exists($fileName)) {
                $com = "touch $fileName";
                @exec($com);
                $com = "chmod 777 $fileName";
                @exec($com);
            }
            file_put_contents($fileName, $content, FILE_APPEND);
            die('error connect');
        }

        mysqli_query($this->db, "SET NAMES 'utf8'");
        mysqli_select_db($this->db, $config['name']);
    }

    public function query($sql) {
        $query = mysqli_query($this->db, $sql);
        if (mysqli_errno($this->db)) {
            $fileName = "mysqli_error_log_".date('Ymd').'.log';
            $content = PHP_EOL. date('Y-m-d H:i:s'). PHP_EOL;
            $content .= mysqli_error($this->db).PHP_EOL;
            if (!file_exists($fileName)) {
                $com = "touch $fileName";
                @exec($com);
                $com = "chmod 777 $fileName";
                @exec($com);
            }
            file_put_contents($fileName, $content, FILE_APPEND);
        }

        return $query;
    }

    public function fetchArray($sql, $id_sort = false) {
        $result = $this->query($sql);

        if (empty($result)) {
            return [];
        }

        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
            if ($id_sort) {
                $rows[$row['id']] = $row;
            } else {
                $rows[] = $row;
            }
        }

        return $rows;
    }

    public function escape_sql($sql) {
        return mysqli_real_escape_string($this->db, $sql);
    }

    public function fetchRow($sql) {
        $result = $this->query($sql);
        if (!$result) {
            die('error query');
        }

        return mysqli_fetch_assoc($result);
    }

    public function insertId() {
        return mysqli_insert_id($this->db);
    }

    public function affectRows() {
        return mysqli_affected_rows($this->db);
    }

    public function close() {
        $this->db->close();
    }

    public function __destruct() {
        // 关闭数据库
        $this->close();
    }
}