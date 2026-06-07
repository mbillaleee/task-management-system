<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $guarded = [];

    protected $casts = [
        'journal_date' => 'date',
        'is_private' => 'boolean',
        'is_favorite' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(JournalCategory::class, 'journal_category_id');
    }
}