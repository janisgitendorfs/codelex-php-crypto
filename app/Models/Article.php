<?php

namespace CryptoApp\Models;

class Article
{
    private string $title;
    private string $content;
    private ?int $id;

    private array $comments = [];

    public function __construct(string $title, string $content, ?int $id = null)
    {
        $this->title = $title;
        $this->content = $content;
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getComments(): array
    {
        return $this->comments;
    }

    public function setComments(array $comments): void
    {
        $this->comments = $comments;
    }
}