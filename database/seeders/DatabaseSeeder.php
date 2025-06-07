<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'you@example.com',
            'password' => Hash::make('password'),
        ]);

        SubscriptionPlan::factory()->create([
            'name' => 'Basic',
            'description' => 'Basic plan',
            'price' => 599,
        ]);

        SubscriptionPlan::factory()->create([
            'name' => 'Pro',
            'description' => 'Pro plan',
            'price' => 1299,
        ]);

        SubscriptionPlan::factory()->create([
            'name' => 'Premium',
            'description' => 'Premium plan',
            'price' => 1999,
        ]);
    }
}
