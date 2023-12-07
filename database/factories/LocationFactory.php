<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'owner_id'=>$this->faker->numberBetween(1, 5),
            'name'=>$this->faker->company(),
            'address'=>$this->faker->address(),
            'zip_code'=>$this->faker->postcode(),
            'city'=>$this->faker->city(),
            'category_id'=>$this->faker->numberBetween(1, 3),
            'description'=>$this->faker->text(191),
        ];
    }
}