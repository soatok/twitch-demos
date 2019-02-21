<?php
$cipher = 'OMQEMDUEQMEK';

$alpha = implode(range('A', 'Z'));
$tf = implode(range('A', 'Z'));


for ($i = 0; $i < 26; ++$i) {
    echo strtr($cipher, $alpha, $tf), PHP_EOL;
    $tf = substr($tf, 1) . substr($tf, 0, 1);
}

