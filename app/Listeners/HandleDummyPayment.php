<?php

namespace App\Listeners;

use App\Events\DummyPaymentEvent;
use App\Modules\DummyPaymentGateway\DummyPaymentGateway;
use Illuminate\Support\Facades\Http;

class HandleDummyPayment
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DummyPaymentEvent $event): void
    {
        $payment = resolve(DummyPaymentGateway::class);
        $payment->setCard($event->card)->setToken($event->paymentToken);
        $token = $payment->getValidToken();

        $payload = [
            'payment_id' => $event->paymentId,
            'payment_token' => $token->getToken(),
            'card_number' => $event->card?->getMasked(),
            'status' => 'success',
        ];


        Http::post(route($event->webhookName), $payload);
    }
}
