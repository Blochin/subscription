<?php

namespace App\Services\PaymentMethod;

use App\Dto\CreatePaymentMethodDto;
use App\Models\PaymentMethod;
use App\Models\User;

class CreatePaymentMethodService
{
    public function create(User $user, CreatePaymentMethodDto $dto)
    {
        return PaymentMethod::firstOrCreate(
            [
                'user_id' => $user->id,
                'payment_token' => $dto->paymentToken,
            ],
            [
                'card_number' => $dto->cardNumber,
            ]
        );
    }
}
