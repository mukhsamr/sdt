<?php

namespace Database\Seeders;

use App\Models\Rak;
use Illuminate\Database\Seeder;

class RakSeeder extends Seeder
{
    public function run()
    {
        Rak::insert([
            ['rak' => 'k'],
            ['rak' => 'l'],
            ['rak' => 'm'],
        ]);
    }
}
