<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use SoftDeletes;

    protected $guarded = [];

     protected $casts = [
        'is_pinned' => 'boolean',
        'is_favorite' => 'boolean',
        'last_edited_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function folder()
    {
        return $this->belongsTo(NoteFolder::class, 'note_folder_id');
    }

    public function category()
    {
        return $this->belongsTo(NoteCategory::class, 'note_category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(NoteTag::class, 'note_tag', 'note_id', 'note_tag_id')
            ->withTimestamps();
    }
}
