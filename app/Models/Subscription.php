<?php

namespace App\Models;

use App\Enums\SubscriptionStatus;
use App\Traits\HasLogs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    use HasFactory;
    use HasLogs;

    protected $fillable = [
        'user_id',
        'subscription_plan_id',
        'status',
    ];

    protected $casts = [
        'status' => SubscriptionStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptionPlan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class)->sorted();
    }
    public function scopeActive($query)
    {
        return $query->where('status', SubscriptionStatus::Active->value);
    }
}
