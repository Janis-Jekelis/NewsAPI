<?php
declare(strict_types=1);

namespace App;

use App\Models\Article;

class ArticleCollection
{
    private const API_KEY = "1d109792a10a4c41939f87200bd0ba08";
    public function getSearchedArticles(string $topic, ?string $from=null, ?string $to=null ): array
    {
        if($from==null)$from="2023-11-08";
        if($to==null)$to="2023-11-08";
        $api="https://newsapi.org/v2/everything?q=$topic&from=$from&to=$to&sortBy=popularity&apiKey=".self::API_KEY;
        $client = new \GuzzleHttp\Client();
        $req=$client->get($api);
        $response =json_decode($req->getBody()->getContents());
        $articles = [];
        foreach ($response->articles as $article) {
                $articles[] = new Article(
                    $article->title,
                    $article->url,
                    $article->urlToImage
                );
        }
        return $articles;
    }
    public function getHeadlines(string $country):array
    {
        $api="https://newsapi.org/v2/top-headlines?country=$country&apiKey=".self::API_KEY;
        $client = new \GuzzleHttp\Client();
        $req=$client->get($api);
        $response =json_decode($req->getBody()->getContents());
        $articles = [];
        foreach ($response->articles as $article){
                $articles[] = new Article(
                    $article->title,
                    $article->url,
                    $article->urlToImage

                );
        }

        return  $articles;
    }

}