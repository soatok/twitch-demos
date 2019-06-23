<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';
$db = \ParagonIE\EasyDB\Factory::create('sqlite:' . __DIR__ . '/data.sql');

$db->exec(
    "CREATE TABLE crawled_pages (
              url TEXT,
              page TEXT
           );"
);
$db->exec(
    "CREATE TABLE crawled_page_links (
              sourced INT REFERENCES crawl_pages(ROWID),
              linkto INT REFERENCES crawl_pages(ROWID)
           );"
);
