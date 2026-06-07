<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalCategory extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function journals()
    {
        return $this->hasMany(Journal::class);
    }
}