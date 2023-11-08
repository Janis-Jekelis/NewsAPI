<?php
declare(strict_types=1);

namespace App;

use App\Models\Article;

class Api
{

    private const API_KEY = "5dfbdad637d04a86929dd50bd4084d95";
    private string $sourceName = "Biztoc.com";
    private object $request;


    public function __construct(string $topic)
    {
        $api="https://newsapi.org/v2/everything?q=$topic&from=2023-10-08&sortBy=publishedAt&apiKey=".self::API_KEY;
        $client = new \GuzzleHttp\Client();
        $req=$client->request("GET",$api);
        $this->request = $req->getBody();
    }

    public function getArticles(): array
    {
        $articles = [];
        $response = $this->request->articles;
        foreach ($response as $article) {
            if ($article->source->name == $this->sourceName) {
                $articles[] =new Article($article->title,$article->description);
            }
        }
        return $articles;
    }
}