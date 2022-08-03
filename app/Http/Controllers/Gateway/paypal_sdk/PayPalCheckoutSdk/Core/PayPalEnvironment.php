<?php

namespace App\Http\Controllers\Gateway\paypal_sdk\PayPalCheckoutSdk\Core;

use App\Http\Controllers\Gateway\paypal_sdk\PayPalCheckoutSdk\Core\PayPalHttp\Environment;

abstract class PayPalEnvironment
{
    private $clientId;
    private $clientSecret;

    public function __construct($clientId, $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    public function authorizationString()
    {
        return base64_encode($this->clientId . ":" . $this->clientSecret);
    }
}

