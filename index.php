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

$page = $client->request('GET', 'https://quotes.toscrape.com/');
$html = $page->getBody()->getContents();

$crawler = new Crawler($html);
$crawler->filter('.quote')->each (function (Crawler $cycle) {

    $text = $cycle->filter('.text')->text();
    $author = $cycle->filter('.author')->text();

    echo "author: " . $author . "\n";
    echo "quote: " . $text . "\n";
    echo "---------------------------\n";
});