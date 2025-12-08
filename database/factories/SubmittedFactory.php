<?php
namespace Database\Factories;

use App\Models\Submitted;
use App\Models\Challenge;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubmittedFactory extends Factory
{
    protected $model = Submitted::class;

    public function definition():array
    {
        return [
            // migration defines user_id as string, so cast to string
            'user_id' => function () {
                return (string) User::factory()->create()->id;
            },
            'challenge_id' => Challenge::factory(),
            'content' => null,
            'pending' => $this->faker->boolean(70),
            'date' => $this->faker->unixTime,
        ];
    }
}
