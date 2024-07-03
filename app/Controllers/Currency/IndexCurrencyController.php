<?php

namespace CryptoApp\Controllers\Currency;

use CryptoApp\Response;
use CryptoApp\Services\Currencies\IndexCurrencyService;
use Exception;

class IndexCurrencyController
{
    private IndexCurrencyService $service;

    public function __construct(IndexCurrencyService $service)
    {

        $this->service = $service;
    }

    public function index() : Response // __invoke()
    {
        try {
            return new Response('currencies/index', [
                'currencies' => $this->service->execute()
            ]);
        } catch (Exception $e) {
            echo "An error occurred: " . $e->getMessage() . "\n";
        }
    }
}