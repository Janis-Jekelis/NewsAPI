<?php
declare(strict_types=1);
use App\Api;
require_once __DIR__."/../vendor/autoload.php";

$p=new Api("tesla");
$g=$p->getArticles();

foreach ($g as $v ){
    echo $v."\n";
}

