<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Difficulty;

class DifficultySeeder extends Seeder
{
    public function run(): void
    {
        Difficulty::factory()->count(0)->state(new \Illuminate\Database\Eloquent\Factories\Sequence(
            ['difficulty' => 'Easy'],
            ['difficulty' => 'Medium'],
            ['difficulty' => 'Hard'],
        ))->create();
    }
}
