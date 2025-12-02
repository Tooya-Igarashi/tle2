<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'name',
        'description',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'badge_user', 'id_badge', 'user_id')
            ->withPivot(['acquire'])
            ->withTimestamps();
    }

    public function challenges()
    {
        return $this->hasMany(Challenge::class);
    }
}
