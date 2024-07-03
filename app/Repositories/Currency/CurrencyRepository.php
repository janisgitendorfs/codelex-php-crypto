<?php

namespace CryptoApp\Repositories\Currency;

use CryptoApp\Exceptions\HttpRequestFailedException;
use CryptoApp\Models\Currency;

interface CurrencyRepository
{
    public function getTop(int $limit = 10): array;

    /**
     * @throws HttpRequestFailedException
     */
    public function search(string $symbol): Currency;
}