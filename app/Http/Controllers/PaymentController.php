<?php

namespace App\Http\Controllers;

use App\Dto\CardDto;
use App\Dto\CreatePaymentMethodDto;
use App\Dto\ProcessPaymentDto;
use App\Events\DummyPaymentEvent;
use App\Http\Requests\PayPaymentRequest;
use App\Http\Requests\ProcessPaymentRequest;
use App\Http\Requests\StorePaymentRequest;
use App\Models\Payment;
use App\Models\Subscription;
use App\Services\Payment\ProcessPaymentService;
use App\Services\PaymentMethod\CreatePaymentMethodService;
use App\Services\Subscription\ActivateSubscriptionService;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    public function __construct(
        private readonly CreatePaymentMethodService $createPaymentMethodService,
        private readonly ProcessPaymentService $dummyPaymentGateway,
        private readonly ActivateSubscriptionService $activateSubscriptionService,
    ) {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        /** @var Subscription $subscription */
        $subscription = Subscription::findOrFail($request->subscription_id);
        $payment = Payment::create([
            'user_id' => auth()->id(),
            'subscription_id' => $subscription->id,
            'amount' => $subscription->subscriptionPlan->price
        ]);

        return Inertia::location(route('payments.show', $payment));
    }

    public function pay(PayPaymentRequest $payPaymentRequest, Payment $payment): Response
    {
        $card = CardDto::fromRequest($payPaymentRequest);
        event(new DummyPaymentEvent(
            paymentId: $payment->id,
            webhookName: $payPaymentRequest->webhook_name,
            paymentToken: $payPaymentRequest->payment_token,
            card: $card,
        ));
        return Inertia::location(route('payments.show', $payment));
    }

    public function cancel(Payment $payment): Response
    {
        $payment->cancel();

        return Inertia::location(route('payments.show', $payment));
    }

    /**
     * Display the specified resource.w
     */
    public function show(Payment $payment): \Inertia\Response
    {
        return Inertia::render('Payment/Show', [
            'payment' => $payment->load('subscription.subscriptionPlan'),
            'payment_methods' => auth()->user()->paymentMethods
        ]);
    }

    public function process(ProcessPaymentRequest $request): ?Subscription
    {
        $user = Payment::with('user')->find($request->payment_id)->user;
        $this->createPaymentMethodService->create($user, new CreatePaymentMethodDto(
            cardNumber: $request->card_number,
            paymentToken: $request->payment_token,
        ));
        $payment = $this->dummyPaymentGateway->process(new ProcessPaymentDto(
            paymentId: $request->payment_id,
            status: $request->status,
        ));
        return $this->activateSubscriptionService->activate($payment);
    }
}
