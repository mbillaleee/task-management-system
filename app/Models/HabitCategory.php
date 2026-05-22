<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HabitCategory extends Model
{
    protected $guarded = [];

    public function habits()
    {
        return $this->hasMany(Habit::class);
    }
}
