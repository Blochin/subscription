<?php

namespace Tests\Feature\Http\Controllers;

use App\Enums\SubscriptionStatus;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_process_payment(): void
    {
        $user = User::factory()->create();

        $subscription = Subscription::factory()->create([
            'user_id' => $user->id,
            'status' => SubscriptionStatus::Pending->value,
        ]);

        $payment = Payment::factory()->create([
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
        ]);

        $response = $this
            ->post(route('payments.process'), [
                'payment_id' => $payment->id,
                'card_number' => '1234123412341234',
                'payment_token' => 'tok_test',
                'status' => 'success',
            ]);

        $response->assertOk();

        $subscription->refresh();
        $this->assertEquals(SubscriptionStatus::Active, $subscription->status);
    }
}