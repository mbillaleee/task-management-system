<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Blog;

class BlogFaq extends Model
{
    protected $fillable = [
        'blog_id',
        'question',
        'answer',
        'sort_order',
    ];

    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }
}
