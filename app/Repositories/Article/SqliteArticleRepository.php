<?php

namespace CryptoApp\Repositories\Article;

use CryptoApp\Models\Article;
use CryptoApp\Repositories\Exceptions\DatabaseRecordNotFoundException;
use Medoo\Medoo;

class SqliteArticleRepository implements ArticleRepository
{
    private Medoo $database;

    public function __construct()
    {
        $this->database = new Medoo([
            'database_type' => 'sqlite',
            'database_name' => 'storage/database.sqlite',
        ]);
    }

    public function getAll(): array
    {
        return [];
    }

    public function getById(int $id): Article
    {
        $articleData = $this->database->select(
            'articles',
            '*',
            [
                'id' => $id
            ]
        );

        if (count($articleData) <= 0)
            throw new DatabaseRecordNotFoundException();

        return new Article(
            $articleData[0]['title'],
            $articleData[0]['content'],
            $articleData[0]['id']
        );
    }
}