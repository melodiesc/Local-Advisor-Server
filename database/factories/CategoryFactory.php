<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use App\Models\PlaceCategory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category' => $this->faker->unique()->randomElement(['Hôtel', 'Bar', 'Restaurant']),
        ];
    }
}
