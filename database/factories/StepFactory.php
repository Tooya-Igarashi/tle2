<?php

namespace Database\Factories;

use App\Models\Step;
use App\Models\Challenge;
use Illuminate\Database\Eloquent\Factories\Factory;

class StepFactory extends Factory
{
    protected $model = Step::class;

    public function definition(): array
    {
        return [
            'step_number' => $this->faker->numberBetween(1, 5),
            'step_description' => $this->faker->paragraph,
            'challenge_id' => Challenge::factory(),
        ];
    }
}
