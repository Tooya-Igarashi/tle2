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
            'image' => "https://www.scoutinggroepdebevers.nl/wp-content/themes/scb-tailpress/img/scblogo256.png",
            'name' => "Bever",
            'description' => "Je hebt een hele mooie bever badge verdiend!",
        ];
    }
}
