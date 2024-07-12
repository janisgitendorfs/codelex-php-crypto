<?php

namespace CryptoApp\Models;

class Comment
{
    private int $sourceId;
    private string $sourceType;
    private string $content;
    private ?int $id;

    public function __construct(
        int $sourceId,
        string $sourceType,
        string $content,
        ?int $id = null
    )
    {

        $this->sourceId = $sourceId;
        $this->sourceType = $sourceType;
        $this->content = $content;
        $this->id = $id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSourceId(): int
    {
        return $this->sourceId;
    }

    public function getSourceType(): int
    {
        return $this->sourceType;
    }
}