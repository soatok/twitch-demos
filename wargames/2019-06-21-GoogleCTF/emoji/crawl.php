<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Crawler.php';

$db = \ParagonIE\EasyDB\Factory::create('sqlite:' . __DIR__ . '/data.sql');
$prefix = 'http://emoji-t0anaxnr3nacpt4na.web.ctfcompetition.com';
$http = new \GuzzleHttp\Client();

$crawler = new Crawler($db, $http, $prefix);
$crawler->crawl('/');

/*
var_dump($db->run(
    "SELECT p.url 
        FROM crawled_pages p 
        JOIN crawled_page_links l ON l.sourced = p.ROWID
        JOIN crawled_pages o ON o.ROWID = l.linkto
        WHERE o.url = ?",
        '2c1ff627fad3ccf58988458183d04207.html'
)
);

$allPages = $db->run('SELECT * FROM crawled_pages');
$pics = [];
foreach ($allPages as $page) {
    preg_match_all('#src="([^"]+)"#', $page['page'], $matches);
    foreach ($matches[1] as $m) {
        $pics[$page['url']] = $m;
    }
}
var_dump($pics);

/*
$popular = $db->row(
    "SELECT count(*), linkto FROM crawled_page_links GROUP BY linkto ORDER BY count(*) DESC LIMIT 1"
);

var_dump(
    $db->row('SELECT * FROM crawled_pages WHERE ROWID = ?', $popular['linkto'])
);

$allPages = $db->run('SELECT ROWID AS id, url FROM crawled_pages');
echo count($allPages) . ' pages crawled.', PHP_EOL, PHP_EOL;
foreach ($allPages as $page) {
    echo $prefix, '/', ltrim($page['url'], '/'), PHP_EOL;
}
foreach ($db->run('SELECT ROWID AS id, url FROM crawled_pages') as $page) {
    echo ' * ', $page['url'], PHP_EOL;
    foreach ($db->run(
        "SELECT p.url 
        FROM crawled_pages p 
        JOIN crawled_page_links l ON l.linkto = p.ROWID
        WHERE l.sourced = ?",
        $page['id']
    ) as $linked) {
        echo '     -> ', $linked['url'], PHP_EOL;
    }
}
*/