<?php
declare(strict_types=1);

namespace App\Controllers;

use App\ArticleCollection;
use App\Response;

class ArticleController
{

       public function index(?string $country = null, ?string $topic = null): Response
    {
        if ($country == null) {
            $country = "us";
        }
        return new Response("index", ["articles" => (new ArticleCollection())->getHeadlines($country)]);

    }
    public function search($topic,?string $from=null, ?string $to=null):Response
    {
        return new Response("search", ["searchedArticles" => (
            new ArticleCollection())->getSearchedArticles($topic,$from, $to)
        ]);


    }
}