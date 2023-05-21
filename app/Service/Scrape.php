<?php

namespace App\Service;

use GuzzleHttp\Client;
use League\HTMLToMarkdown\HtmlConverter;
use Symfony\Component\DomCrawler\Crawler;

class Scrape
{
    public $title;

    public function handle($url)
    {
        $url = $url;
        $client = new Client();
        $response = $client->get($url,  [
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                'Accept-Encoding' => 'gzip',
            ],
        ]);

        $htmlContent = $response->getBody()->getContents();
        $dom = new Crawler($htmlContent);

        // Clean this tags: <style> <script> <span> <footer> <aside> <nav>
        $cleanHtml = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $htmlContent);
        $cleanHtml = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', $htmlContent);
        $cleanHtml = preg_replace('/<footer\b[^>]*>(.*?)<\/footer>/is', '', $cleanHtml);
        $cleanHtml = preg_replace('/<nav\b[^>]*>(.*?)<\/nav>/is', '', $cleanHtml);
        $cleanHtml = preg_replace('/<span[^>]*>(.*?)<\/span>/is', '$1', $cleanHtml);


        $converter = new HtmlConverter(array('strip_tags' => true, 'strip_placeholder_links' => true));
        $converter->getEnvironment()->addConverter(new PreTagConverter());

        $markdownContent = $converter->convert($cleanHtml);
        try {
            $this->title = $dom->filter('title')->first()->text();
        } catch (\Exception $e) {
            $this->title = substr($markdownContent, 0, strpos($markdownContent, "\n"));
        }

        return $markdownContent;
    }
}