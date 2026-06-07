<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    protected $guarded = [];
 
    protected $casts = [
        'is_active'  => 'boolean',
        'start_date' => 'date',
        'end_date'   => 'date',
    ];
 
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_challenges')
            ->withPivot(['progress', 'is_completed', 'completed_at'])
            ->withTimestamps();
    }
}
 