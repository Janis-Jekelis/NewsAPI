<?php
declare(strict_types=1);

namespace App;

class Api
{
    private const API_KEY = "5dfbdad637d04a86929dd50bd4084d95";
    private string $sourceName = "Biztoc.com";
    private object $request;


    public function __construct(string $topic)
    {
        $key=self::API_KEY;
        $this->request = (json_decode(file_get_contents(
            "https://newsapi.org/v2/everything?q=$topic&from=2023-10-08&sortBy=publishedAt&apiKey=$key"
        )));
    }

    public function getArticles(): array
    {
        $articles = [];
        $response = $this->request->articles;
        foreach ($response as $article) {
            if ($article->source->name == $this->sourceName) {
                $articles[] = $article->description;
            }
        }
        return $articles;
    }
}