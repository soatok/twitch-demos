<?php

$string = file_get_contents('program', 'rb');
$map = [
    '🍡' => 'add',
      '🤡' => 'clone',
      '📐' => 'divide',
      '😲' => 'if_zero',
      '😄' => 'if_not_zero',
      '🏀' => 'jump_to',
      '🚛' => 'load',
      '📬' => 'modulo',
      '⭐' => 'multiply',
      '🍿' => 'pop',
      '📤' => 'pop_out',
      '🎤' => 'print_top',
      '📥' => 'push',
      '🔪' => 'sub',
      '🌓' => 'xor',
      '⛰' => 'jump_top',
      '⌛' => 'exit'
];
$search = array_keys($map);
$replace = array_values($map);

file_put_contents('program2', str_replace($search, $replace, $string));

