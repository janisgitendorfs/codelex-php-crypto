<?php

namespace CryptoApp\Services\Currencies;

use CryptoApp\Models\Transaction;
use CryptoApp\Repositories\Currency\CurrencyRepository;
use CryptoApp\Repositories\Transaction\TransactionRepository;
use Exception;
use Psr\Log\LoggerInterface;

class BuyCurrencyService
{
    private CurrencyRepository $currencyRepository;
    private TransactionRepository $transactionRepository;
    private LoggerInterface $logger;

    public function __construct(
        CurrencyRepository $currencyRepository,
        TransactionRepository $transactionRepository,
        LoggerInterface $logger
    )
    {
        $this->currencyRepository = $currencyRepository;
        $this->transactionRepository = $transactionRepository;
        $this->logger = $logger;
    }

    public function execute(string $symbol, float $amount): void
    {
        try {
            $currency = $this->currencyRepository->search($symbol);

            $transaction = new Transaction(
                'buy',
                $symbol,
                $amount,
                $currency->getPrice(),
                time() // TODO: use Carbon
            );

            $this->transactionRepository->save($transaction);

            $this->logger->info('[BUY] ' . $symbol . ' x ' . $amount . ' - ' . $currency->getPrice());

        } catch (Exception $e) {
            // echo "Error: " . $e->getMessage();
            // TODO: throw our exception
            var_dump($e->getMessage());
        }
    }
}