<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Step extends Model
{
    use HasFactory;

    protected $fillable = [
        'step_number',
        'step_description',
        'challenge_id',
    ];

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }
}
