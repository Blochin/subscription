<?php

namespace App\Dto;

use App\Http\Requests\PayPaymentRequest;
use App\Modules\DummyPaymentGateway\Contracts\CardInterface;

class CardDto implements CardInterface
{
    public function __construct(
        public ?string $number = null,
        public ?string $expiration = null,
        public ?string $cvv = null,
    ) {
    }

    public static function fromRequest(PayPaymentRequest $payPaymentRequest): ?static
    {
        if ($payPaymentRequest->payment_token) {
            return null;
        }
        return new self(
            $payPaymentRequest->card_number,
            $payPaymentRequest->expiration,
            $payPaymentRequest->cvv,
        );
    }
    public function getNumber(): string
    {
        return $this->number;
    }

    public function getExpiration(): string
    {
        return $this->expiration;
    }

    public function getCvv(): string
    {
        return $this->cvv;
    }

    public function getMasked(): string
    {
        return str_repeat('*', 12) . substr($this->number, -4);
    }

    public function isValid(): bool
    {
        return strlen($this->number) === 16 && strlen($this->cvv) === 3;
    }
}
