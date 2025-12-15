<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'difficulty_id',
        'user_id',
        'badge_id',
        'published',
        'duration',
        'image',
        'image_path',
        'step_number',
        'step_description'
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($q, $search) {
            $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        });

        $query->when($filters['difficulty'] ?? null, function ($q, $difficultyId) {
            $q->where('difficulty_id', $difficultyId);
        });

        return $query;
    }


    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function completedByUsers()
    {
        return $this->belongsToMany(
            User::class,
            'challenge_completions'
        )->withPivot('completed_at');
    }


    public function difficulty()
    {
        return $this->belongsTo(Difficulty::class);
    }

    public function steps()
    {
        return $this->hasMany(Step::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submitted::class);
    }

    public function joinedUsers()
    {
        return $this->belongsToMany(User::class, 'user_challenge', 'challenge_id', 'id_user');
    }

    public function badge()
    {
        return $this->belongsTo(Badge::class, 'badge_id');
    }
}
