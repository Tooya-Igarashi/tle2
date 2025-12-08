<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BadgeUserSeeder extends Seeder
{
    public function run():void
    {
        $users = User::all();
        $badges = Badge::all();

        if ($users->isEmpty() || $badges->isEmpty()) {
            return;
        }

        // randomly assign badges
        foreach ($users as $user) {
            $take = rand(0, min(1, $badges->count()));

            if ($take === 0) {
                continue;
            }

            $assigned = $badges->random($take);

            foreach (collect($assigned) as $b) {
                DB::table('badge_user')->insert([
                    'id_badge' => $b->id,
                    'user_id' => $user->id,
                    'acquire' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
