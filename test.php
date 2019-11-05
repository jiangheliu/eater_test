<?php
$arr=array();
$flag=0;
for($i=0;$i<4;$i++){
    $flag=$i*2;
    for($j=0;$j<2;$j++){
        $flag++;
        $arr[$i][]=$flag;
    }
}
var_dump($arr);
//顺时针打印矩阵
function printMatrix($arr){
    $res=array();
    $row=count($arr);
    $col=count($arr[0]);
    $circle=intval((($row>$col ? $col : $row)-1)/2+1);
    for($i=0;$i<$circle;$i++){
        //转圈开始
        //从左到右
        for($j=$i;$j<=$col-1;$j++){
            $t=$arr[$i][$j];
            if(in_array($t,$res)) continue;
            $res[]=$t;
        }
        //从上到下
        for($k=$i+1;$k<$row-$i;$k++){
            $t=$arr[$k][$col-$i-1];

            if(in_array($t,$res)) continue;
            $res[]=$t;
        }
        //从右到左
        for($m=$col-$i-2;$m>=$i;$m--){
            $t=$arr[$row-$i-1][$m];
            if(in_array($t,$res)) continue;
            $res[]=$t;
        }
        //从下到上
        for($n=$row-$i-2;$n>$i;$n--){
            $t=$arr[$n][$i];
            if(in_array($t,$res)) continue;
            $res[]=$t;
        }
    }
    return $res;
}
$res=printMatrix($arr);