<?php
// 实现一个function foo($num) 完成如下功能
//
// foo(1) = [[1]];
// foo(2) = [ [1,2]
//            [4,3]  ];
// foo(3) = [ [7,8,9]
//            [6,1,2]
//            [5,4,3] ];
// foo(4) = [ [7,8,9,10]
//            [6,1,2,11]
//            [5,4,3,12]
//            [16,15,14,13] ];
//
// foo(5)....
//
// foo(n)...
//依次类推，组成一个风车型排列
//
//
$num = 5;
$arr = foo($num);
for( $i = 0; $i < $num ; $i ++  ){
    echo implode(", ", $arr[$i]) . "\n";
}



function foo($num){
    // 定位起始位置
    if ($num % 2 == 1) {
        $begin = -(($num - 1) / 2);
        $end = ($num - 1) / 2;
    } else {
        $begin = -($num / 2) + 1;
        $end = $num / 2;
    }

    $array = array();
    for ($x = $begin; $x <= $end; $x++) {
        for ($y = $begin; $y <= $end; $y++) {
            $array[$y][$x] = fun($x, $y);
        }
    }

    $data = array();
    if (empty($array)) {
        return $data;
    }

    $array = array_values($array);
    foreach ($array as $k => $val) {
        $data[$k] = array_values($val);
    }

    return $data;
}


// 这是一个螺旋队列问题
function fun($x, $y) {
    $layer = max_num(abs($x), abs($y));
    $base = 2 * $layer + 1;

    if ($y == -$layer) {
        $key = $base * $base + $y + $x;
    } elseif ($y == $layer) {
        $key = $base * $base - 2 * $base + 2 - ($x + $y);
    } elseif ($x == -$layer && ($layer != abs($y))) {
        $key = $base * $base - $base + 1 - (-$x + $y);
    } elseif ($x == $layer && $layer != abs($y)) {
        $key = $base * $base - 3 * $base + 3 - ($x - $y);
    } else {
        echo 'error';
        return -1;
    }

    return $key;
}

function max_num($x, $y) {
    return abs($x) > abs($y) ? (abs($x)) : (abs($y));
}
