<?php

function fibonacci($n) {
    if ($n < 2) {
        return $n;
    }

    return fibonacci($n -2) + fibonacci($n -1);
}


echo fibonacci(7).PHP_EOL;


function factorial($n) {
    if ($n > 0) {
        return factorial($n -1) * $n;
    }

    return 1;
}

echo factorial(10).PHP_EOL;

