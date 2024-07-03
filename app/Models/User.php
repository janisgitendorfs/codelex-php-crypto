<?php

namespace CryptoApp\Models;

class User
{
    private string $id;
    private string $username;
    private string $password;

    // TODO: created_at, updated_at

    public function __construct(
        string $id,
        string $username,
        string $password
    )
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}