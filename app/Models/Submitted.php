<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Submitted extends Model
{
    use HasFactory;

    protected $table = 'submitted';

    protected $fillable = [
        'user_id',
        'challenge_id',
        'content',
        'pending',
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }
}
