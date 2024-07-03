<?php

namespace CryptoApp\Services\Currencies;

use CryptoApp\Repositories\Currency\CurrencyRepository;

class IndexCurrencyService
{
    private CurrencyRepository $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function execute(): array
    {
        return $this->currencyRepository->getTop();
    }
}