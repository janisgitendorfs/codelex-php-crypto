<?php

namespace CryptoApp\Controllers\Currency;

use CryptoApp\RedirectResponse;
use CryptoApp\Services\Currencies\SellCurrencyService;

class SellCurrencyController
{
    private SellCurrencyService $service;

    public function __construct(SellCurrencyService $service)
    {
        $this->service = $service;
    }

    public function sell(string $symbol): RedirectResponse // __invoke()
    {
        $this->service->execute($symbol, $_POST['amount']);

        return new RedirectResponse('/transactions');
    }
}