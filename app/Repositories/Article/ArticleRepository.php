<?php

namespace CryptoApp\Repositories\Article;

use CryptoApp\Models\Article;

interface ArticleRepository
{
    /** @return array<Article> */
    public function getAll(): array;
    public function getById(int $id): Article;
}