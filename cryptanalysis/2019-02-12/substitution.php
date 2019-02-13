<?php
declare(strict_types=1);

/**
 * Simple substitution cipher
 *
 * @param string $input
 * @param string $key
 * @return string
 */
function substitution(string $input, string $key): string
{
    $from = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return \strtr($input, $from, \strtolower($key) . \strtoupper($key));
}

/**
 * Unbiased substitution cipher keygen
 *
 * @return string
 * @throws Exception
 */
function random_key(): string
{
    $possible = 'abcdefghijklmnopqrstuvwxyz';
    $key = '';
    $len = 26;
    do {
        $idx = \random_int(0, $len);
        $key .= $possible[$idx];
        $possible = \substr($possible, 0, $idx) . \substr($possible, $idx + 1);
        --$len;
    } while (!empty($possible));
    return $key;
}

$key = random_key();
var_dump($key);
