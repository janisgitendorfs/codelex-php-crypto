<?php

namespace CryptoApp\Repositories\Comment;

use CryptoApp\Models\Comment;
use CryptoApp\Models\Transaction;
use Medoo\Medoo;

class SqliteCommentRepository implements CommentRepository
{
    private Medoo $database;

    public function __construct()
    {
        $this->database = new Medoo([
            'database_type' => 'sqlite',
            'database_name' => 'storage/database.sqlite',
        ]);
    }

    public function getBySource(string $sourceType, int $sourceId): array
    {
        $comments = [];

        $commentsData = $this->database->select('comments', '*', [
            'source_type' => $sourceType,
            'source_id' => $sourceId,
        ]);

        foreach ($commentsData as $data) {
            $comments[] = new Comment(
                $sourceId,
                $sourceType,
                $data['content'],
                $data['id']
            );
        }

        return $comments;
    }
}