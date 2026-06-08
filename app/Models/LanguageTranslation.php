<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LanguageTranslation extends Model
{
    protected $guarded = [];

    public function language()
    {
        return $this->belongsTo(Language::class, 'lang', 'language_code');
    }
}
