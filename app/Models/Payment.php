<?php

namespace App\Models;

use App\Casts\Money;
use App\Enums\PaymentStatus;
use App\Traits\HasLogs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;
    use HasLogs;

    protected $fillable = [
        'user_id',
        'subscription_id',
        'amount',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime:F j, Y H:i',
        'updated_at' => 'datetime:F j, Y H:i',
        'status' => PaymentStatus::class,
        'amount' => Money::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function cancel(Payment $payment): void
    {
        $payment->status = PaymentStatus::Cancelled;
        $payment->save();
    }

    public function scopeSorted(Builder $query, string $column = 'created_at', string $direction = 'desc'): Builder
    {
        return $query->orderBy($column, $direction);
    }
}
