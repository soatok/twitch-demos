<?php

/**
 * @param string $plaintext
 * @param string $key
 * @param string $iv
 * @return string
 */
function aes256cbc_encrypt(string $plaintext, string $key, string $iv): string
{
    return $iv . \openssl_encrypt($plaintext, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
}

/**
 * @param string $message
 * @param string $key
 * @return string
 */
function aes256cbc_decrypt(string $message, string $key): string
{
    $iv = \mb_substr($message, 0, 16, '8bit');
    $cipher = \mb_substr($message, 16, null, '8bit');
    return \openssl_decrypt($cipher, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
}


$plaintext = "The dhole (pronounced \"dole\") is also known as the Asiatic wild dog, red dog, and whistling dog.";
$key = \random_bytes(32);
$iv = \random_bytes(16);

$encrypted = aes256cbc_encrypt($plaintext, $key, $iv);
$decrypted = aes256cbc_decrypt($encrypted, $key, $iv);
// var_dump($decrypted === $plaintext);

var_dump(bin2hex($key), bin2hex($encrypted));
