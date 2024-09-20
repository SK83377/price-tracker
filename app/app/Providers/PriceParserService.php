<?php

namespace App\Providers;

use Goutte\Client;

use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Log;

class PriceParserService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function parsePriceFromUrl($url)
    {
        try {
            $html = file_get_contents($url);

            $price = $this->extractPrice($html);

            return $price;
        } catch (\Exception $e) {
            throw new \Exception('Wrong URL');
        }
    }

    private function extractPrice($html)
    {
        $pattern = '/<h3 class="css-90xrc0">(\d{1,3}(?: \d{3})*) zł<\/h3>/';

        if (preg_match($pattern, $html, $matches)) {
            $priceText = $matches[1];

            $cleanPrice = str_replace(' ', '', $priceText);
            return (int)$cleanPrice;
        }

        throw new \Exception('Wrong URL');
    }
}