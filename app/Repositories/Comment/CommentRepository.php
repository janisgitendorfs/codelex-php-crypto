<?php

namespace CryptoApp\Repositories\Comment;

use CryptoApp\Models\Comment;

interface CommentRepository
{
    /** @return array<Comment> */
    public function getBySource(string $sourceType, int $sourceId): array;
}