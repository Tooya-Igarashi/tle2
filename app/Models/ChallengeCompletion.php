<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChallengeCompletion extends Model
{
    protected $table = 'challenge_completions';

    protected $fillable = [
        'user_id',
        'challenge_id',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    // Relaties (optioneel maar netjes)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }
}
