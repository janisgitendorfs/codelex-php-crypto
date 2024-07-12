<?php

namespace CryptoApp\Controllers\Currency;

use CryptoApp\Response;
use CryptoApp\Services\Currencies\ShowCurrencyService;
use Exception;

class ShowCurrencyController
{
    private ShowCurrencyService $service;

    public function __construct(
        ShowCurrencyService $service
    )
    {
        $this->service = $service;
    }

    public function show(string $symbol): Response
    {
        try {
            return new Response('currencies/show', [
                'currency' => $this->service->execute($symbol)
            ]);
        } catch (Exception $e) {
            echo "An error occurred: " . $e->getMessage() . "\n";
        }
    }
}