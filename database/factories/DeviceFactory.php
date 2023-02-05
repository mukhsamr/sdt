<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DeviceFactory extends Factory
{
    public function definition()
    {
        return [
            'uid' => fake()->uuid(),
            'jenis' => fake()->randomElement(['laptop', 'hp']),
            'rak_id' => rand(1, 3),
        ];
    }
}
