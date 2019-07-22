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

// 获取概率数据
function getRate($rates) {
    $sum = 0;
    $formatRates = array();
    foreach ($rates as $key => $rate) {
        $from = $sum + 1;
        $sum += $rate;
        $formatRates[$key] = array($from, $sum);
    }
    $max = $sum;
    return array($formatRates, $max);
}

// curl请求
function curlGet($url, $data) {
    $url = '';

}

// 整数发红包算法
function redPacket($money, $num) {
    $total = 0;
    $arr = array();

    // 随机出
    for ($i = 1; $i < $num; $i++) {
        if ($i == 1) {
            $total = $money;
        }

        // 避免出现红包里没钱
        $rand = rand(1, $total - 1);
        if ($rand > $total / 2) {
            $rand = $total - $rand;
        }

        $arr[] = $rand;
        $total -= $rand;
    }

    $end = $money - array_sum($arr);
    $arr[] = $end;
    var_dump($arr);
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
    $user = array(); // 根据传入的参数查找对应用户

    if (empty($user)) {
        return false;
    }


    if ($user['passport'] != $passport) {
        return false;
    }

    // 登录数据记录日志

    return true;
}

// 校验数据
function check() {
    // 检验对比玩家数据，提取对应的用户数据

}

// 生成不重复数字的验证码
function createCode($num) {
    $codeArr = range(0, 9);
    $code = array_rand($codeArr, $num);
    shuffle($code);

    $roomPassport = implode('', $code);
    var_dump($roomPassport);
}


// 获取数组最大深度
function deep($arr) {
    $max = 0;
    if (!is_array($arr)) {
        return $max;
    }
    foreach ($arr as $value) {
        if (is_array($value)) {
            $depth = deep($value) + 1;
            if ($depth > $max) {
                $max = $depth;
            }
        }
    }
    return $max;
}

