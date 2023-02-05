<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RakSeeder::class
        ]);

        User::factory()->create([
            'nama' => 'mukh',
            'email' => 'mukhsamr@gmail.com',
            'password' => '$2a$12$/L16Ts1FarPWB7soB.NQ8.a9WKYQ.HAstNtAWAGmrD71W/HEDuBy6', // password
            'level' => 'admin',
            'remember_token' => Str::random(10),
        ]);

        User::factory(10)->create();

        Student::factory(50)->hasDevices(1)->create();
    }
}
