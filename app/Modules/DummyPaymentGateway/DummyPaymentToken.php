<?php

namespace App\Modules\DummyPaymentGateway;

class DummyPaymentToken
{
    public function __construct(
        public string $token
    ) {
    }
    public function getToken(): string
    {
        return $this->token;
    }
}
