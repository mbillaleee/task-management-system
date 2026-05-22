<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HabitLog extends Model
{
    protected $guarded = [];

    protected $casts = [
        'log_date' => 'date',
        'is_completed' => 'boolean',
    ];

    public function habit()
    {
        return $this->belongsTo(Habit::class);
    }
}
