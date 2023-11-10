<?php
declare(strict_types=1);

namespace App;

use App\Models\Article;
use Carbon\Carbon;

class ArticleCollection
{
    private const API_KEY = "1d109792a10a4c41939f87200bd0ba08";

    public function getSearchedArticles(string $topic, ?string $from = null, ?string $to = null): array
    {
        if ($from == null) $from = (Carbon::yesterday())->format("Y-m-d");
        if ($to == null) $to = (Carbon::now())->format("Y-m-d");
        $api = "https://newsapi.org/v2/everything?q=$topic&from=$from&to=$to&sortBy=popularity&apiKey=" . self::API_KEY;
        $client = new \GuzzleHttp\Client();
        $req = $client->get($api);
        $response = json_decode($req->getBody()->getContents());
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
        $api = "https://newsapi.org/v2/top-headlines?country=$country&apiKey=" . self::API_KEY;
        $client = new \GuzzleHttp\Client();
        $req = $client->get($api);
        $response = json_decode($req->getBody()->getContents());
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