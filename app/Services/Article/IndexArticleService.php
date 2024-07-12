<?php

namespace CryptoApp\Services\Article;

use CryptoApp\Models\Article;
use CryptoApp\Repositories\Article\ArticleRepository;
use CryptoApp\Repositories\Comment\CommentRepository;

class IndexArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function execute(): array
    {
        return [];
    }
}