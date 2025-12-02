<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BadgeUser extends Pivot
{
    protected $table = 'badge_user';

    protected $fillable = [
        'id_badge',
        'user_id',
        'acquire',
    ];
}
