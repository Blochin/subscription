<?php

namespace App\Services\Payment\Mapper;

use App\Enums\PaymentStatus;

class StatusMapper
{
    public static function map(string $externalStatus): PaymentStatus
    {
        return match ($externalStatus) {
            'success', => PaymentStatus::Success,
            'pending', => PaymentStatus::Pending,
            'failed', => PaymentStatus::Failed,
            default => PaymentStatus::Failed,
        };
    }
}
