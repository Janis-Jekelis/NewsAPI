<?php
declare(strict_types=1);
namespace App\Models;

class Article
{
private string $title;
private string $imageLink;
private string $newsLink;
    public function __construct(
        string $title,
        string $newsLink,
        ?string $imageLink=null
    )
    {
        $this->title = $title;
        if($imageLink==null) {
            $this->imageLink = "/paper.jpg";
        }else {
            $this->imageLink=$imageLink;
        }
        $this->newsLink=$newsLink;
    }

    public function getTitle(): string
    {
        return $this->title;
    }


    public function getImageLink():string
    {
        return $this->imageLink;
    }

    public function getNewsLink(): string
    {
        return $this->newsLink;
    }
}
