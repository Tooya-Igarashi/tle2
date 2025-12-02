<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rank',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function challenges()
    {
        return $this->hasMany(Challenge::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submitted::class);
    }

    public function joinedChallenges()
    {
        return $this->belongsToMany(Challenge::class, 'user_challenge', 'id_user', 'challenge_id');
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'badge_user', 'user_id', 'id_badge')
            ->withPivot(['acquire'])
            ->withTimestamps();
    }
}
