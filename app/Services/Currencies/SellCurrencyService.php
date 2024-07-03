<?php

namespace CryptoApp\Services\Currencies;

use CryptoApp\Models\Transaction;
use CryptoApp\Repositories\Currency\CurrencyRepository;
use CryptoApp\Repositories\Transaction\TransactionRepository;
use Exception;

class SellCurrencyService
{
    private CurrencyRepository $currencyRepository;
    private TransactionRepository $transactionRepository;

    public function __construct(
        CurrencyRepository $currencyRepository,
        TransactionRepository $transactionRepository
    )
    {
        $this->currencyRepository = $currencyRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function execute(string $symbol, float $amount): void
    {
        try {
            $currency = $this->currencyRepository->search($symbol);

            // TODO: Find transaction / wallet info to get current amount of $symbol (BTC)

            // TODO: Check if I have enough of $symbol

            $transaction = new Transaction(
                'sell',
                $symbol,
                $amount,
                $currency->getPrice(),
                time() // TODO: use Carbon
            );

            $this->transactionRepository->save($transaction);

        } catch (Exception $e) {
            // echo "Error: " . $e->getMessage();
            // TODO: throw our exception
        }
    }
}