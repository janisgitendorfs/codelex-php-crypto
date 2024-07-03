<?php

namespace CryptoApp\Repositories\User;

use CryptoApp\Models\User;

interface UserRepository
{
    public function getByUsername(string $username): ?User;
}