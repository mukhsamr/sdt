<?php

namespace App\Console\Commands;

use App\Models\Pinjam;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PinjamKembali extends Command
{
    protected $signature = 'pinjam:kembali';

    protected $description = 'Kembalikan Semua Device';

    public function handle()
    {
        try {
            $kembali = Pinjam::whereDate('created_at', '<=', date('Y-m-d'))->delete();

            Log::info($kembali . ' device dikembalikan');
        } catch (\Throwable $th) {
            Log::error($th);
        }

        return;
    }
}
