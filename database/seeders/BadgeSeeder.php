<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class BadgeSeeder extends Seeder
{
    public function run(): void
    {
        $badges = [
            [
                'image' => 'images/BeaverBadge.png',
                'name' => 'Bever',
                'description' => 'Je hebt de Bever badge verdiend!'
            ],
            [
                'image' => 'images/BergBadge.png',
                'name' => 'Berg',
                'description' => 'Je hebt de Berg badge verdiend!'
            ],
            [
                'image' => 'images/FlowerBadge.png',
                'name' => 'Bloem',
                'description' => 'Je hebt de Bloem badge verdiend!'
            ],
            [
                'image' => 'images/FoxBadge.png',
                'name' => 'Vos',
                'description' => 'Je hebt de Vos badge verdiend!'
            ],
            [
                'image' => 'images/OwlBadge.png',
                'name' => 'Uil',
                'description' => 'Je hebt de Uil badge verdiend!'
            ],
            [
                'image' => 'images/PlantBadge.png',
                'name' => 'Plant',
                'description' => 'Je hebt de Plant badge verdiend!'
            ],
            [
                'image' => 'images/WaterBadge.png',
                'name' => 'Water',
                'description' => 'Je hebt de Water badge verdiend!'
            ],
            [
                'image' => 'images/WindmolenBadge.png',
                'name' => 'Windmolen',
                'description' => 'Je hebt de Windmolen badge verdiend!'
            ],
            [
                'image' => 'images/ZonBadge.png',
                'name' => 'Zon',
                'description' => 'Je hebt de Zon badge verdiend!'
            ],
        ];

        Badge::factory()
            ->count(count($badges))
            ->state(new Sequence(...$badges))
            ->create();
    }
}
