<?php

namespace CryptoApp\Services\Currencies;

use CryptoApp\Models\Currency;
use CryptoApp\Repositories\Currency\CurrencyRepository;

class ShowCurrencyService
{
    private CurrencyRepository $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function execute(string $symbol): Currency
    {
        return $this->currencyRepository->search($symbol);
    }
}