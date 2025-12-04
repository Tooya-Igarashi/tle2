<?php

namespace Database\Factories;

use App\Models\Challenge;
use App\Models\Difficulty;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChallengeFactory extends Factory
{
    protected $model = Challenge::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'difficulty_id' => Difficulty::factory(),
            'user_id' => User::factory(),
            'badge_id' => Badge::factory(),
            'published' => true,
            'duration' => "00:15:00",
            'image_path' => "https://geonius.nl/uploads/images/nieuws/dag%20van%20de%20bever_header.jpg"
        ];
    }

}
