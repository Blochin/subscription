<?php

namespace App\Http\Controllers;

use App\Enums\SubscriptionStatus;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Models\Subscription;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Subscription $subscription): \Inertia\Response
    {
        $subscription->load(['subscriptionPlan', 'payments']);
        return Inertia::render('Subscription/Show', [
            'subscription' => $subscription,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubscriptionRequest $request): Response
    {
        $subscription = Subscription::firstOrCreate([
                'user_id' => auth()->user()->id,
                'subscription_plan_id' => $request->subscription_plan_id,
                'status' => SubscriptionStatus::Pending,
            ]);
        return Inertia::location(route('subscriptions.show', $subscription));
    }

    public function cancel(Subscription $subscription): Response
    {
        $subscription->update([
            'status' => SubscriptionStatus::Cancelled
        ]);

        return Inertia::location(route('subscriptions.show', $subscription));
    }
}
