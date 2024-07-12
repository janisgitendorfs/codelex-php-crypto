<?php

namespace CryptoApp\Controllers\Currency;

use CryptoApp\Response;
use Exception;

class TestDeleteController
{
    public function delete(string $id)
    {
        var_dump("delete " . $id);
        die;
    }
}