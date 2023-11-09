<?php
declare(strict_types=1);
namespace App\Models;

class Article
{
private string $title;
private string $description;
private string $imageLink;
private string $newsLink;
    public function __construct(
        string $title,
        string $description,
        string $imageLink,
        string $newsLink
    )
    {

        $this->title = $title;
        $this->description = $description;
        $this->imageLink=$imageLink;
        $this->newsLink=$newsLink;
    }

    public function getTitle(): string
    {
        return $this->title;
    }


    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImageLink(): string
    {
        return $this->imageLink;
    }

    public function getNewsLink(): string
    {
        return $this->newsLink;
    }
}
