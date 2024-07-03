<?php

namespace CryptoApp\Services\User;

use CryptoApp\Exceptions\AuthenticationFailedException;
use CryptoApp\Models\User;
use CryptoApp\Repositories\Exceptions\DatabaseRecordNotFoundException;
use CryptoApp\Repositories\User\UserRepository;

class AuthUserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $username, string $password): User
    {
        try {
            $user = $this->userRepository->getByUsername($username);

            if ($user != null && $user->getPassword() === md5($password))
            {
                return $user;
            }

            throw new AuthenticationFailedException("Auth failed. Password mismatch.");
        } catch (DatabaseRecordNotFoundException $exception)
        {
            throw new AuthenticationFailedException("Auth failed", 0, $exception);
        }
    }
}