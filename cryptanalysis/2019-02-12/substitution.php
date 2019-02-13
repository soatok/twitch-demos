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
        $idx = \random_int(0, $len - 1);
        $key .= $possible[$idx];
        $possible = \substr($possible, 0, $idx) . \substr($possible, $idx + 1);
        --$len;
    } while (!empty($possible));
    return $key;
}

/**
 * @param string $ciphertext
 * @return array
 */
function decompose(string $ciphertext): array
{
    $keys = \str_split('abcdefghijklmnopqrstuvwxyz', 1);
    $freq = \array_fill_keys($keys, 0);
    $len = \strlen($ciphertext);
    for ($i = 0; $i < $len; ++$i) {
        $c = \strtolower($ciphertext[$i]);
        if (array_key_exists($c, $freq)) {
            $freq[$c]++;
        }
    }
    return $freq;
}

$example = "The African wild dog (Lycaon pictus), also known as the painted hunting dog,[2] painted wolf,[3] African hunting dog,[4] Cape hunting dog or African painted dog,[5][6] is a canid native to sub-Saharan Africa. It is the largest of its family in Africa, and the only extant member of the genus Lycaon, which is distinguished from Canis by dentition highly specialised for a hypercarnivorous diet, and a lack of dewclaws. It was classified as endangered by the IUCN in 2016, as it had disappeared from much of its original range. The 2016 population was estimated at roughly 39 subpopulations containing 6,600 adults, only 1,400 of which were reproductive.[7] The decline of these populations is ongoing, due to habitat fragmentation, human persecution and disease outbreaks.[1]

The African wild dog is a highly social animal, living in packs with separate dominance hierarchies for males and females. Uniquely among social carnivores, the females rather than the males scatter from the natal pack once sexually mature and the young are allowed to feed first on carcasses. The species is a specialised diurnal hunter of antelopes, which it catches by chasing them to exhaustion. Like other canids, it regurgitates food for its young, but this action is also extended to adults, to the point of being the bedrock of African wild dog social life.[8][9][10] It has few natural predators, though lions are a major source of mortality and spotted hyenas are frequent kleptoparasites.

Although not as prominent in African folklore or culture as other African carnivores, it has been respected in several hunter-gatherer societies, particularly those of the predynastic Egyptians and the San people.";

$key = random_key();

$plaintext = "Dholes are dogs! The dhole (pronounced \"dole\") is also known as the Asiatic wild dog, red dog, and whistling dog. It is about the size of a German shepherd but looks more like a long-legged fox. This highly elusive and skilled jumper is classified with wolves, coyotes, jackals, and foxes in the taxonomic family Canidae.

Dholes are unusual dogs for a number of reasons. They don’t fit neatly into any of the dog subfamilies (wolf and fox, for instance). Dholes have only two molars on each side of their lower jaw, instead of three, and have a relatively shorter jaw than their doggie counterparts. Also, female dholes have more teats than other canid species and can produce up to 12 pups per litter.

Dholes are incredibly athletic. They are fast runners, excellent swimmers, and impressive jumpers. These skills are critical when the pack is hunting. In some protected areas, they share habitat with tigers and leopards.";

echo substitution($plaintext, $key), PHP_EOL;

$ciphertext = "Qutjld nhl qtwd! Zul qutjl (mhtatgaplq \"qtjl\") fd njdt katca nd zul Ndfnzfp cfjq qtw, hlq qtw, naq cufdzjfaw qtw. Fz fd nxtgz zul dfrl ts n Wlhena dulmulhq xgz jttkd ethl jfkl n jtaw-jlwwlq sti. Zufd ufwujv ljgdfbl naq dkfjjlq ogemlh fd pjnddfsflq cfzu ctjbld, ptvtzld, onpknjd, naq stild fa zul znitatefp snefjv Pnafqnl.

Qutjld nhl gagdgnj qtwd sth n agexlh ts hlndtad. Zulv qta’z sfz alnzjv fazt nav ts zul qtw dgxsnefjfld (ctjs naq sti, sth fadznapl). Qutjld unbl tajv zct etjnhd ta lnpu dfql ts zulfh jtclh onc, fadzlnq ts zuhll, naq unbl n hljnzfbljv duthzlh onc zuna zulfh qtwwfl ptgazlhmnhzd. Njdt, slenjl qutjld unbl ethl zlnzd zuna tzulh pnafq dmlpfld naq pna mhtqgpl gm zt 12 mgmd mlh jfzzlh.

Qutjld nhl faphlqfxjv nzujlzfp. Zulv nhl sndz hgaalhd, lipljjlaz dcfeelhd, naq femhlddfbl ogemlhd. Zuldl dkfjjd nhl phfzfpnj cula zul mnpk fd ugazfaw. Fa dtel mhtzlpzlq nhlnd, zulv dunhl unxfznz cfzu zfwlhd naq jltmnhqd.";

$decomposed = decompose($ciphertext);
\arsort($decomposed);

// $common = 'etaoinsrhdlucmfywgpbvkxqjz';
$common = \implode('', \array_keys($decomposed));

$freq = 'lndtzfahjuqpgswemcvbkxoiry';
$guess = 'easotinrlhdcufgmpwyvkbjxzq';
// $guess = \implode('', \array_keys($decomposed));

$from = $common . \strtoupper($common);
$to = $guess . \strtoupper($guess);

$plainmaybe = \strtr($ciphertext, $from, $to);

