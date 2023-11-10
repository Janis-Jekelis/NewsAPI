<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;

class Article
{
    private string $title;
    private string $imageLink;
    private string $newsLink;
    private string $publishedAt;

    public function __construct(
        string  $title,
        string  $newsLink,
        string  $publishedAt,
        ?string $imageLink = null
    )
    {
        $this->title = $title;
        if ($imageLink == null) {
            $this->imageLink = "Views/img/paper.jpg";
        } else {
            $this->imageLink = $imageLink;
        }
        $this->newsLink = $newsLink;
        $this->publishedAt = (Carbon::parse($publishedAt))->format("Y-m-d");
    }

    public function getTitle(): string
    {
        return $this->title;
    }


    public function getImageLink(): string
    {
        return $this->imageLink;
    }

    public function getNewsLink(): string
    {
        return $this->newsLink;
    }

    public function getPublishedAt(): ?string
    {
        return $this->publishedAt;
    }
}
