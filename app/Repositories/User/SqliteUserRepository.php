<?php

namespace CryptoApp\Repositories\User;

use CryptoApp\Models\User;
use CryptoApp\Repositories\Exceptions\DatabaseRecordNotFoundException;
use Medoo\Medoo;

class SqliteUserRepository implements UserRepository
{
    private Medoo $database;

    public function __construct()
    {
        $this->database = new Medoo([
            'database_type' => 'sqlite',
            'database_name' => 'storage/database.sqlite',
        ]);
    }

    public function getByUsername(string $username): User
    {
        $userData = $this->database->select(
            'users',
            '*',
            [
                'username' => $username
            ]
        );

        if (count($userData) <= 0)
            throw new DatabaseRecordNotFoundException("User by username $username not found.");

        return new User(
            $userData[0]['id'],
            $userData[0]['username'],
            $userData[0]['password'],
        );
    }
}