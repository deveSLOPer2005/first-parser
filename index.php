<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

$client = new Client ([
    'verify' => false,
    'headers' => [
        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0'
    ]
]);

$allQuotes = [];

for ($pageNumber = 1; $pageNumber <= 3; $pageNumber++) {
    $url = 'https://quotes.toscrape.com/page/' . $pageNumber . '/';
    $page = $client->request('GET', $url);
    $html = $page->getBody()->getContents();

    $crawler = new Crawler($html);
    $crawler->filter('.quote')->each (function (Crawler $cycle) use (&$allQuotes) {

    $text = $cycle->filter('.text')->text();
    $author = $cycle->filter('.author')->text();

    $allQuotes[] = [
        'author' => $author,
        'text' => $text
        ];
        });
        sleep(1);
}
echo "done. quotes count: " . count($allQuotes) . "\n";
print_r($allQuotes);