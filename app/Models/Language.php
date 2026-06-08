<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $guarded = [];

    public function translations()
    {
        return $this->hasMany(LanguageTranslation::class, 'lang', 'language_code');
    }
}
