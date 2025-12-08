<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Submitted;
use App\Models\Challenge;
use App\Models\User;

class SubmittedSeeder extends Seeder
{
    public function run(): void
    {
        // relies on existing users and challenges; create more if needed
        User::factory()->count(5)->create();
        Challenge::factory()->count(5)->create();

        Submitted::factory()->count(10)->create();
    }
}
