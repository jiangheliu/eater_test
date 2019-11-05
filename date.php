<?php
/*
+-------------------------------------------------------------------------------
| Author: lzp
+-------------------------------------------------------------------------------
*/

// 时间

const DATE_DAY = 'Y-m-d';
const DATE_TIME = 'Y-m-d H:i:s';

echo date(DATE_DAY);
echo date(DATE_TIME);

// 时间
strtotime(date(DATE_DAY));

// 周一
strtotime('monday this week');

// 周日
strtotime('sunday this week');


time(); // 定位当前时间戳

microtime(); // 可用于计算程序运行时间





