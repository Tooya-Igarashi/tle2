<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $table = 'submitted';
    protected $fillable = ['id', 'user_id', 'challenge_id', 'content', 'pending', 'date'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

