<?php

namespace CryptoApp\Services\Article;

use CryptoApp\Models\Article;
use CryptoApp\Repositories\Article\ArticleRepository;
use CryptoApp\Repositories\Comment\CommentRepository;

class ShowArticleService
{
    private ArticleRepository $articleRepository;
    private CommentRepository $commentRepository;

    public function __construct(
        ArticleRepository $articleRepository,
        CommentRepository $commentRepository
    )
    {
        $this->articleRepository = $articleRepository;
        $this->commentRepository = $commentRepository;
    }

    public function execute(int $id): Article
    {
        $article = $this->articleRepository->getById($id);

        $comments = $this->commentRepository->getBySource(
            basename(Article::class),
            $id
        );

        $article->setComments($comments);

        return $article;
    }
}