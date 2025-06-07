<?php

namespace App\Services\Subscription\Mapper;

use App\Enums\SubscriptionStatus;

class StatusMapper
{
    public static function map(string $externalStatus): SubscriptionStatus
    {
        return match ($externalStatus) {
            'success', => SubscriptionStatus::Active,
            'pending', => SubscriptionStatus::Pending,
            'failed', => SubscriptionStatus::Failed,
            'canceled', => SubscriptionStatus::Cancelled,
            default => SubscriptionStatus::Failed,
        };
    }
}
