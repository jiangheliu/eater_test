<?php

define('TASK_TYPE_1', 1);
define('TASK_TYPE_2', 2);
define('TASK_TYPE_3', 3);

class TaskBaseModel {
    public $taskTypes; // 任务类型数据
    public $progress = array();

    public $user_id; // 唯一标识ID
    public $_module; // 功能名

    public function __construct($uid, $progress, $module = null) {
        $this->user_id = $uid;
        $this->_module = $module;
        $this->progress = $progress;
    }

    /**
     * 数据更新
     *
     * @param $type
     * @param $progress
     * @return array
     */
    public function task_update($type, $progress) {
        $isSave = $this->set_progress($type, $progress);

        return array($isSave, $this->progress);
    }

    /**
     * 获取当期任务类型的进度
     *
     * @param $type
     * @return array|mixed
     */
    public function get_task_current($type) {
        $current_progress = $this->progress[$type];
        return empty($current_progress) ? [] : $current_progress;
    }

    /**
     * 重置的任务类型进度
     *
     * @param $type
     * @param bool $init
     * @return array
     */
    public function task_reset($type, $init = false) {
        unset($this->progress[$type]);
        $init && $this->progress[$type] = $this->task_init($type);
        return $this->progress;
    }

    /**
     * 检测是否完成任务
     *
     * @param $type
     * @param $targets
     * @return bool
     */
    public function is_completed($type, $targets) {
        switch ($type) {
            case TASK_TYPE_1:
                return $this->check_special($type, $targets);
            default:
                return $this->check_common($type, $targets);
        }
    }

    /**
     * 在需要初始化任务的地方调用
     *
     * @param $type
     * @return array
     */
    public function task_init($type) {
        switch ($type) {
            case TASK_TYPE_1:
                $this->progress[$type][0] = 0;
                break;
            default:
                break;
        }
        return $this->progress;
    }

    /**
     * 获取任务进度
     *
     * @param $type
     * @param null $progress
     * @return bool
     */
    private function set_progress($type, $progress = null) {
        $is_save = false;
        switch ($type) {
            case TASK_TYPE_1:
                $is_save = true;
                empty($this->progress[$type]) && $this->progress[$type] = [];
                $this->progress[$type][0] = (int) $this->progress[$type][0] + $progress;
                break;
            default:
                break;
        }

        return $is_save;
    }

    /**
     * 通关ID为XX的BOSS关
     *
     * @param $type
     * @param $targets
     * @return bool
     */
    private function check_special($type, $targets) {
        if ($type != TASK_TYPE_2) {
            return false;
        }

        if (empty($this->progress[$type])
            || empty($targets)) {
            return false;
        }

        $special_id = $targets[0];
        return in_array($special_id, $this->progress[$type]);
    }

    /**
     * 通用检测
     *
     * @param $type
     * @param $targets
     * @return bool
     */
    private function check_common($type, $targets) {
        if (empty($this->progress[$type])
            || empty($targets)) {
            return false;
        }

        $progress = $this->progress[$type];
        foreach ($targets as $k => $target) {
            if ($target > $progress[$k]) {
                return false;
            }
        }

        return true;
    }
}




