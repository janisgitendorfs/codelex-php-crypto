<?php

namespace CryptoApp\Controllers\Currency;

use CryptoApp\RedirectResponse;
use CryptoApp\Response;
use CryptoApp\Services\Currencies\BuyCurrencyService;

class BuyCurrencyController
{
    private BuyCurrencyService $service;

    public function __construct(BuyCurrencyService $service)
    {
        $this->service = $service;
    }

    public function buyForm(): Response
    {
        return new Response('currencies/buy');
    }

    public function buy() : RedirectResponse
    {
        // try/catch
        $this->service->execute(
            $_POST['symbol'],
            $_POST['amount']
        );

        return new RedirectResponse('/transactions');
    }
}