<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HabitCategory extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function habits()
    {
        return $this->hasMany(Habit::class);
    }
}
