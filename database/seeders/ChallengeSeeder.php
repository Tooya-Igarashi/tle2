<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Challenge;
use App\Models\Step;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ChallengeSeeder extends Seeder
{
    public function run()
    {
        // ensure sample users exist
        $users = User::factory()->count(1)->create();

        // create challenges and steps, and fill pivot `user_challenge`
        Challenge::factory()
            ->count(3)
            ->create()
            ->each(function ($challenge) use ($users) {
                Step::factory()->count(1)->create(['challenge_id' => $challenge->id]);

                // attach a few users to user_challenge table
                $randomUsers = $users->random(rand(1, $users->count()));
                foreach ($randomUsers as $u) {
                    DB::table('user_challenge')->insert([
                        'id_user' => $u->id,
                        'challenge_id' => $challenge->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            });
    }
}
