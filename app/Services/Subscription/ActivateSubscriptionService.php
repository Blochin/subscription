<?php

namespace App\Services\Subscription;

use App\Models\Payment;
use App\Models\Subscription;
use App\Services\Subscription\Mapper\StatusMapper;

class ActivateSubscriptionService
{
    public function activate(Payment $payment): ?Subscription
    {
        $subscription = $payment->subscription;
        $subscription->update([
            'status' => StatusMapper::map($payment->status->value)->value
        ]);
        return $subscription;
    }
}
