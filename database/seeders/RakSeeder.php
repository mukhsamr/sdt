<?php

namespace Database\Seeders;

use App\Models\Rak;
use Illuminate\Database\Seeder;

class RakSeeder extends Seeder
{
    public function run()
    {
        Rak::insert([
            [
                'rak' => 'k',
                'tipe' => 'fq',
            ],
            [
                'rak' => 'l',
                'tipe' => 'fq',
            ],
            [
                'rak' => 'm',
                'tipe' => 'qbs',
            ],
            [
                'rak' => 'n',
                'tipe' => 'qbs',
            ],
        ]);
    }
}
