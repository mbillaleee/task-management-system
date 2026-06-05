<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FocusSession extends Model
{
    protected $guarded = [];

    protected $casts = [
        'fullscreen_mode' => 'boolean',
        'distraction_free' => 'boolean',
        'started_at' => 'datetime',
        'paused_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function histories()
    {
        return $this->hasMany(FocusSessionHistory::class);
    }

    public function getAudioFileAttribute()
    {
        return match ($this->ambient_sound) {
            'white_noise' => 'white-noise.mp3',
            'rain' => 'rain.mp3',
            'lofi' => 'lofi.mp3',
            default => null,
        };
    }
}
