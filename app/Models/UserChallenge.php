<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserChallenge extends Model
{
    protected $guarded = [];
 
    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];
 
    public function user()
    {
        return $this->belongsTo(User::class);
    }
 
    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }
}
 