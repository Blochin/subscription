<?php

namespace App\Dto;

class CreatePaymentMethodDto
{
    public function __construct(
        public ?string $cardNumber,
        public string $paymentToken,
    ) {
    }
}
