<?php

namespace CryptoApp;

use CryptoApp\Repositories\Transaction\TransactionRepository;

class Wallet
{
    private float $balance;

    private TransactionRepository $transactionRepository;

    public function __construct(
        float $initialBalance,
        TransactionRepository $transactionRepository
    )
    {
        $this->balance = $initialBalance;
        $this->transactionRepository = $transactionRepository;
    }

    public function calculateWalletState(): array
    {
        $state = [];
        $balance = $this->balance;

        foreach ($this->transactionRepository->getAll() as $transaction) {
            $symbol = strtoupper($transaction->getSymbol());
            $amount = $transaction->getAmount();
            $total = $transaction->getPrice() * $amount;

            if ($transaction->getType() === 'buy') {
                $balance -= $total;
                if (!isset($state[$symbol])) {
                    $state[$symbol] = 0;
                }
                $state[$symbol] += $amount;
            } elseif ($transaction->getType() === 'sell') {
                $balance += $total;
                if (!isset($state[$symbol])) {
                    $state[$symbol] = 0;
                }
                $state[$symbol] -= $amount;
            }
        }

        $state['balance'] = $balance;
        return $state;
    }

    public function getBalance(): float
    {
        $state = $this->calculateWalletState();
        return $state['balance'];
    }
}