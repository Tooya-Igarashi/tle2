<?php

namespace Database\Factories;

use App\Models\Badge;
use Illuminate\Database\Eloquent\Factories\Factory;

class BadgeFactory extends Factory
{
    protected $model = Badge::class;

    public function definition(): array
    {
        return [
            'image' => null, // wordt overschreven in seeder
            'name' => null,  // wordt overschreven in seeder
            'description' => null, // wordt overschreven in seeder
        ];
    }
}
