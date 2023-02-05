<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    public function definition()
    {
        return [
            'uid' => fake()->uuid(),
            'nama' => fake()->name(),
            'tipe' => fake()->randomElement(['fq', 'qbs']),
        ];
    }
}
