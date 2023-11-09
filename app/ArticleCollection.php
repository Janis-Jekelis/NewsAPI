<?php
declare(strict_types=1);

namespace App;

use App\Models\Article;

class ArticleCollection
{

    private const API_KEY = "5dfbdad637d04a86929dd50bd4084d95";
    private string $sourceName = "Biztoc.com";


    public function getSearchedArticles($topic): array
    {
        $api="https://newsapi.org/v2/everything?q=$topic&from=2023-10-08&sortBy=publishedAt&apiKey=".self::API_KEY;
        $client = new \GuzzleHttp\Client();
        $req=$client->get($api);
        $response =json_decode($req->getBody()->getContents());
        $articles = [];
        foreach ($response as $article) {
            if ($article->source->name == $this->sourceName) {
                $articles[] =new Article($article->title,$article->description);
            }
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
            if($article->urlToImage!=null) {
                $articles[] = new Article(
                    $article->title,
                    $article->description,
                    $article->urlToImage,
                    $article->url
                );
            }
        }

        return  $articles;
    }

}