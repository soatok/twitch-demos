<?php
use GuzzleHttp\Client;
use ParagonIE\EasyDB\EasyDB;

/**
 * Class Crawler
 */
class Crawler
{
    /** @var EasyDB $db */
    private $db;

    /** @var Client $http */
    private $http;

    /** @var string $prefix */
    private $prefix;

    public function __construct(EasyDB $db, Client $http, string $prefix = '')
    {
        $this->db = $db;
        $this->http = $http;
        $this->prefix = $prefix;
    }

    /**
     * @param string $startUrl
     * @param int|null $from
     * @return bool
     * @throws Exception
     */
    public function crawl(string $startUrl, ?int $from = null): bool
    {
        // Skip duplicates
        $existingId = $this->db->cell(
            "SELECT ROWID FROM crawled_pages WHERE url = ?",
            $startUrl
        );
        if ($existingId) {
            if ($from) {
                $this->db->insert(
                    'crawled_page_links',
                    [
                        'sourced' => $from,
                        'linkto' => $existingId
                    ]
                );
            }
            return true;
        }

        // Do a crawl
        list ($body, $urls) = $this->getPage($startUrl);
        $newId = $this->db->insertGet(
            'crawled_pages',
            [
                'url' => $startUrl,
                'page' => $body
            ],
            'ROWID'
        );

        if ($from) {
            $this->db->insert(
                'crawled_page_links',
                [
                    'sourced' => $from,
                    'linkto' => $newId
                ]
            );
        }
        foreach ($urls as $url) {
            $this->crawl($url, $newId);
        }
        return false;
    }

    /**
     * @param string $url
     * @return array {0: string, 1: string[]}
     */
    protected function getPage(string $url): array
    {
        $response = $this->http->get($this->prefix . '/' . ltrim($url, '/'));
        $body = $response->getBody()->getContents();
        return [$body, $this->getUrlsFromBody($body)];
    }

    /**
     * @param string $body
     * @return array
     */
    protected function getUrlsFromBody(string $body): array
    {
        $res = [];
        // preg_match_all('#([0-9a-f]+\.html)#', $body, $res);
        preg_match_all('#href=\'([^\']+)\'#', $body, $res);
        return $res[1];
    }
}
