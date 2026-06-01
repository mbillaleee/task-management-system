<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoteTag extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function notes()
    {
        return $this->belongsToMany(Note::class, 'note_tag', 'note_tag_id', 'note_id')
            ->withTimestamps();
    }
}
