<?php

declare(strict_types=1);

namespace App;

use App\Models\Article;
use Carbon\Carbon;
use GuzzleHttp\Client;

class Api
{
    private Client $client;
    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = $_ENV['API_KEY'];
        $this->client = new Client();
    }

    public function getSearchedArticles(string $topic, ?string $from = null, ?string $to = null): array
    {
        if ($from == null) $from = (Carbon::yesterday())->format("Y-m-d");
        if ($to == null) $to = (Carbon::now())->format("Y-m-d");
        $api = "https://newsapi.org/v2/everything?q=$topic&from=$from&to=$to&sortBy=popularity&apiKey=$this->apiKey";
        $request = $this->client->get($api);
        $response = json_decode($request->getBody()->getContents());
        $articles = [];
        foreach ($response->articles as $article) {
            $articles[] = new Article(
                $article->title,
                $article->url,
                $article->publishedAt,
                $article->urlToImage
            );
        }
        return $articles;
    }

    public function getHeadlines(string $country): array
    {
        $api = "https://newsapi.org/v2/top-headlines?country=$country&apiKey=$this->apiKey";
        $request = $this->client->get($api);
        $response = json_decode($request->getBody()->getContents());
        $articles = [];
        foreach ($response->articles as $article) {
            $articles[] = new Article(
                $article->title,
                $article->url,
                $article->publishedAt,
                $article->urlToImage
            );
        }
        return $articles;
    }
}