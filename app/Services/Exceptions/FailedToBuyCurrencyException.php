<?php

namespace CryptoApp\Services\Exceptions;

use LogicException;

class FailedToBuyCurrencyException extends LogicException
{
    private const MESSAGE = "This is custom message";
    public static function create(?Throwable $throwable = null, $code = 500)
    {
        throw new self(self::MESSAGE, $code, $throwable);
    }
}