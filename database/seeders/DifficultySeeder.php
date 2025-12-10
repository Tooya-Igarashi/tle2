<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Difficulty;

class DifficultySeeder extends Seeder
{
    public function run(): void
    {
        Difficulty::create(['difficulty' => 'Easy']);
        Difficulty::create(['difficulty' => 'Medium']);
        Difficulty::create(['difficulty' => 'Hard']);
    }
}
