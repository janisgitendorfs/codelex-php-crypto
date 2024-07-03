<?php

use CryptoApp\Controllers\Currency\BuyCurrencyController;
use CryptoApp\Controllers\Currency\IndexCurrencyController;
use CryptoApp\Controllers\Currency\SellCurrencyController;
use CryptoApp\Controllers\Currency\ShowCurrencyController;
use CryptoApp\Controllers\TransactionController;

return [
    ['GET', '/', [IndexCurrencyController::class, 'index']],
    ['GET', '/currencies', [IndexCurrencyController::class, 'index']],

    ['GET', '/transactions', [TransactionController::class, 'index']],

    ['GET', '/currencies/buy', [BuyCurrencyController::class, 'buyForm']],
    ['POST', '/currencies/buy', [BuyCurrencyController::class, 'buy']],

    ['GET', '/currencies/{symbol}', [ShowCurrencyController::class, 'show']],
    ['POST', '/currencies/{symbol}/sell', [SellCurrencyController::class, 'sell']],
];