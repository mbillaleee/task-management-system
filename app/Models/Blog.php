<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\BlogCategory;
use App\Models\User;
use App\Models\BlogFaq;

class Blog extends Model
{
    protected $fillable = [
        'blog_category_id',
        'user_id',
        'title',
        'slug',
        'thumbnail',
        'short_description',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'views',
        'is_featured',
        'status',
        'published_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(BlogFaq::class);
    }
}
