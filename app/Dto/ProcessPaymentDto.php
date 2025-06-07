<?php

namespace App\Dto;

class ProcessPaymentDto
{
    public function __construct(
        public int $paymentId,
        public string $status,
    ) {
    }
}
