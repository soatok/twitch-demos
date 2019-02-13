<?php
declare(strict_types=1);

function oracle(string $ciphertext): string
{
    return aes256cbc_decrypt(
        $ciphertext,
        hex2bin('b5b9d2b92738c1f659b533167b553ae11222928edc0a924b80c4c7c15ceb03f4')
    );
}

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

/*
$plaintext = "The dhole (pronounced \"dole\") is also known as the Asiatic wild dog, red dog, and whistling dog.";
$key = \random_bytes(32);
$iv = \random_bytes(16);

$encrypted = aes256cbc_encrypt($plaintext, $key, $iv);
$decrypted = aes256cbc_decrypt($encrypted, $key, $iv);
// var_dump($decrypted === $plaintext);

var_dump(bin2hex($key), bin2hex($encrypted));
*/

/*
$message = hex2bin('01b4eff6a533ed5b18df826201d7209d741fdeb8d8e86d10e66ad4b72cb1fc3b2f01919c99d2943087d86c8e123d0e496ffefccd067ff6d38194ad30d211241060acf2ee1eda20d1013685d1604b66434f106991a1d8a8b1830f015d9ae29193be6bd17ac9277bb99d101b88c79e84c0a2ea535b7764036568fed881b6a0532e');
*/
$message = hex2bin(
    '01b4eff6a533ed5b18df826201d7209d741fdeb8d8e86d10e66ad4b72cb1fc3b2f01919c99d29430'.
    '87d86c8e123d0e496ffefccd067ff6d38194ad30d211241060acf2ee1eda20d1013685d1604b66434f106'.
    '991a1d8a8b1830f015d9ae29193be6bd17ac9277bb99d101b88c79e84c0a2ea535b7764036568fed881b6'.
    'a0532e'
);
$len = mb_strlen($message, '8bit');
for ($i = $len - 1; $i >= 0; --$i) {
    $mPrime = $message;
    for ($j = 1; $j < 256; ++$j) {
        $mPrime[$i] = chr(ord($mPrime[$i]) ^ $j);
        try {
            oracle($message);
        } catch (\TypeError $ex) {
            var_dump($i . ' at offset ' . $j);
        }
    }
    exit;
}

