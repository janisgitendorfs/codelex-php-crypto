<?php

namespace CryptoApp\Controllers;

use CryptoApp\Repositories\Transaction\SqliteTransactionRepository;
use CryptoApp\Repositories\Transaction\TransactionRepository;
use CryptoApp\Response;

class TransactionController
{
    private TransactionRepository $repository;

    public function __construct()
    {
        $this->repository = new SqliteTransactionRepository();
    }

    public function index(): Response
    {
        $transactions = $this->repository->getAll();

        return new Response('transactions/index', [
            'transactions' => $transactions
        ]);
    }
}