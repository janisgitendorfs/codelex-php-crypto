<?php

namespace CryptoApp\Controllers;

use CryptoApp\Response;
use CryptoApp\Services\Article\IndexArticleService;
use CryptoApp\Services\Article\ShowArticleService;

class ArticlesController
{
    private IndexArticleService $indexArticleService;
    private ShowArticleService $showArticleService;

    public function __construct(
        IndexArticleService $indexArticleService,
        ShowArticleService $showArticleService
    )
    {
        $this->indexArticleService = $indexArticleService;
        $this->showArticleService = $showArticleService;
    }

    public function index(): Response
    {
        return new Response('articles/index', [
            'articles' => $this->indexArticleService->execute()
        ]);
    }

    public function show(string $id): Response
    {
        $article = $this->showArticleService->execute((int) $id);

        return new Response('articles/show', [
            'article' => $article
        ]);
    }
}