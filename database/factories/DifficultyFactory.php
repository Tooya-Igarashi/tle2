<?php
namespace Database\Factories;

use App\Models\Difficulty;
use Illuminate\Database\Eloquent\Factories\Factory;

class DifficultyFactory extends Factory
{
    protected $model = Difficulty::class;

    public function definition():array
    {
        return [
            'difficulty' => $this->faker->randomElement(['Easy', 'Medium', 'Hard']),
        ];
    }
}
