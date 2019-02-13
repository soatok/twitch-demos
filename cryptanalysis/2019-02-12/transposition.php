<?php

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
        $idx = \random_int(0, $len - 1);
        $key .= $possible[$idx];
        $possible = \substr($possible, 0, $idx) . \substr($possible, $idx + 1);
        --$len;
    } while (!empty($possible));
    return $key;
}

/**
 * @param string $input
 * @param int $size
 * @return string
 */
function transpose(string $input, int $size): string {
    $chunks = str_split($input, $size);
    $count = count($chunks);
    $cipher = '';
    for ($i = 0; $i < $count; ++$i) {
        $n = ($i + 123) % $count;
        $cipher .= \strrev($chunks[$n]);
    }
    return $cipher;
}


$plaintext = "Dholes are dogs! The dhole (pronounced \"dole\") is also known as the Asiatic wild dog, red dog, and whistling dog. It is about the size of a German shepherd but looks more like a long-legged fox. This highly elusive and skilled jumper is classified with wolves, coyotes, jackals, and foxes in the taxonomic family Canidae.

Dholes are unusual dogs for a number of reasons. They don't fit neatly into any of the dog subfamilies (wolf and fox, for instance). Dholes have only two molars on each side of their lower jaw, instead of three, and have a relatively shorter jaw than their doggie counterparts. Also, female dholes have more teats than other canid species and can produce up to 12 pups per litter.

Dholes are incredibly athletic. They are fast runners, excellent swimmers, and impressive jumpers. These skills are critical when the pack is hunting. In some protected areas, they share habitat with tigers and leopards.";

$key1 = random_key();
$key2 = 4;
$cipher = transpose($plaintext, $key2);
$pieces = str_split($cipher, 4);
foreach ($pieces as $i => $v) {
    $pieces[$i] = \strrev($v);
}
echo json_encode($pieces), PHP_EOL;
