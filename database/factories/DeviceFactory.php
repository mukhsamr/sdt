<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DeviceFactory extends Factory
{
    public function definition()
    {
        return [
            'uid' => fake()->randomNumber(9, true),
            'jenis' => fake()->randomElement(['laptop', 'hp']),
            'rak_id' => rand(1, 3),
        ];
    }
}
