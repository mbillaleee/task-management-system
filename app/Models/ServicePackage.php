<?php

namespace App\Models;

use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServicePackage extends Model
{
    protected $fillable = [
        'service_id',
        'type',
        'title',
        'price',
        'description',
        'delivery_days',
        'revisions',
        'included',
        'status',
    ];

    protected $casts = [
        'included' => 'array',
        'status' => 'boolean',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    
}
