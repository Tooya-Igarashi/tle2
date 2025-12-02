<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Difficulty extends Model
{
    use HasFactory;

    protected $fillable = ['difficulty'];

    public function challenges()
    {
        return $this->hasMany(Challenge::class);
    }
}
