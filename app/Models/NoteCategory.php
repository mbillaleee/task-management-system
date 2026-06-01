<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoteCategory extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class, 'note_category_id');
    }
}
