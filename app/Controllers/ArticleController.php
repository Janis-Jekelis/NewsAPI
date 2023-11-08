<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Api;
use App\Response;

class ArticleController
{
    public function index():Response
    {
      return  new Response("index",(new Api("tesla"))->getArticles());

    }
}