<?php
/*
+-------------------------------------------------------------------------------
| Author: lzp
+-------------------------------------------------------------------------------
*/

/**
 * 获取对应基数的反转排序算法
 *
 * 示例：baseNum = 5， maxNum = 10；baseNum = 5， maxNum = 11
 * 结果：5,6,4,7,3,8,2,9,1,10；5,6,4,7,3,8,2,9,1,10,11
 *
 * @param $baseNum
 * @param $maxNum
 * @return array|bool
 */
function getSequence($baseNum, $maxNum) {
    if ($baseNum <= 0 || $maxNum <= 0 || $baseNum > $maxNum) {
        return false;
    }
    $data = array();
    for ($i = 1; $i <= $maxNum; $i++) {
        if ($i < ($baseNum * 2)) {
            if ($i % 2 == 0) {
                $num = $baseNum + $i / 2;
                if ($num <= $maxNum) {
                    $data[] = $baseNum + $i / 2;
                }
            } else {
                $data[] = $baseNum - ($i - 1) / 2;
            }
        } else {
            $data[] = $i;
        }
    }

    if ($maxNum % 2 == 0 && $baseNum > ($maxNum / 2)) {
        $num = $baseNum - ($maxNum / 2);
        for ($i = $num; $i >= 1; $i--) {
            $data[] = $i;
        }
    }

    if ($maxNum % 2 == 1 && $baseNum > (($maxNum - 1) / 2)) {
        $num = $baseNum - (($maxNum - 1) / 2) -1;
        for ($i = $num; $i >= 1; $i--) {
            $data[] = $i;
        }
    }

    return $data;
}


// 基础概率计算
function rate($num, $max) {
    $randNum = rand(1, $max); // 随机取值

    if ($randNum > $num) {
        return false;
    } else {
        return false;
    }
}

// curl请求
function curlGet($url, $data) {

}

// curl请求
function curlPost($url, $data) {

}


// 版本对比
function version($baseVersion, $compareVersion) {
    return version_compare($baseVersion, $compareVersion);
}

// 登陆
function login($userName, $passport) {

}

// 校验数据
function check() {

}

