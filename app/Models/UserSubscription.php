<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSubscription extends Model
{
    protected $guarded = [];

    protected $casts = [
        'amount_paid'    => 'decimal:2',
        'starts_at'      => 'datetime',
        'ends_at'        => 'datetime',
        'trial_ends_at'  => 'datetime',
        'cancelled_at'   => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isExpired(): bool
    {
        return $this->ends_at && $this->ends_at->isPast();
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'active'    => 'bg-emerald-500/10 text-emerald-400',
            'trial'     => 'bg-blue-500/10 text-blue-400',
            'cancelled' => 'bg-red-500/10 text-red-400',
            'expired'   => 'bg-gray-500/10 text-gray-400',
            default     => 'bg-gray-500/10 text-gray-400',
        };
    }
}
