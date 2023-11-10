<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Api;
use App\Response;

class ArticleController
{

    public function index(?string $country = null, ?string $topic = null): Response
    {
        if ($country == null) {
            $country = "us";
        }
        return new Response("index",
            [
                "articles" => (new Api())->getHeadlines($country)
            ]
        );
    }

    public function search($topic, ?string $from = null, ?string $to = null): Response
    {
        return new Response("search",
            [
                "searchedArticles" => (new Api())->getSearchedArticles($topic, $from, $to)
            ]
        );
    }
}
