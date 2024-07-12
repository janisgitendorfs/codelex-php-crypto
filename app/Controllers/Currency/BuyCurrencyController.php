<?php

namespace CryptoApp\Controllers\Currency;

use CryptoApp\RedirectResponse;
use CryptoApp\Response;
use CryptoApp\Services\Currencies\BuyCurrencyService;
use Respect\Validation\Validator;

class BuyCurrencyController
{
    private BuyCurrencyService $service;
    private Validator $validator;

    public function __construct(BuyCurrencyService $service, Validator $validator)
    {
        $this->service = $service;
        $this->validator = $validator;
    }

    public function buyForm(): Response // GET
    {
        return new Response('currencies/buy');
    }

    public function buy() : RedirectResponse // POST
    {
        $validated = $this->validator
            ->number()
            ->greaterThan(0)
            ->validate($_POST['amount']);

        if ($validated == false)
        {
            $_SESSION['_input'] = $_POST;
            $_SESSION['_errors'] = [
                'amount' => 'Amount must be a number'
            ];

            return new RedirectResponse('/currencies/buy');
        }

        $this->service->execute(
            $_POST['symbol'],
            $_POST['amount']
        );

        $_SESSION['_message'] = 'Thank you for your purchase';

        return new RedirectResponse('/currencies/buy');
    }
}