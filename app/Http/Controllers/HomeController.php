<?php

namespace App\Http\Controllers;

use App\Models\Pinjam;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Home', [
            'now' => now()->translatedFormat('l, d F Y'),
            'pinjam' => Pinjam::has('student')
                ->select('id', 'student_id', 'device_id', 'created_at')
                ->with(['student:id,nama', 'device:id,jenis'])
                ->whereDate('created_at', date('Y-m-d'))
                ->get(),
            'kembali' => Pinjam::has('student')
                ->select('id', 'student_id', 'device_id', 'deleted_at')
                ->with(['student:id,nama', 'device:id,jenis'])
                ->whereDate('created_at', date('Y-m-d'))
                ->onlyTrashed()
                ->get(),
            'sedang_dipinjam' => Pinjam::has('student')
                ->select('id', 'student_id', 'device_id', 'created_at')
                ->with(['student:id,nama', 'device:id,jenis'])
                ->orderBy('created_at')
                ->get()
                ->each
                ->append('tanggal')
        ]);
    }
}
