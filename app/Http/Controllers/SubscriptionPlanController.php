<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use Inertia\Inertia;

class SubscriptionPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        $subscriptionPlans = SubscriptionPlan::all();

        return Inertia::render('SubscriptionPlan/Index', [
            'subscriptionPlans' => $subscriptionPlans,
            'user' => auth()->user()->load('activeSubscriptions.subscriptionPlan'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(SubscriptionPlan $subscriptionPlan)
    {
        return Inertia::render('SubscriptionPlan/Show', [
            'subscriptionPlan' => $subscriptionPlan,
            'user' => auth()->user()->load('activeSubscriptions.subscriptionPlan'),
        ]);
    }
}
