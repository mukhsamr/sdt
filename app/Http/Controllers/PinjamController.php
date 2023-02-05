<?php

namespace App\Http\Controllers;

use App\Http\Requests\PinjamRequest;
use App\Models\Device;
use App\Models\Pinjam;
use App\Models\Rak;
use App\Models\Student;
use App\Traits\HasTryCatch;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PinjamController extends Controller
{
    use HasTryCatch;

    public function pinjam(Request $request)
    {
        return Inertia::render('Pinjam', [
            'siswa' => Student::select('id', 'uid', 'nama')
                ->where('is_block', null)
                ->get(),

            'device' => Device::select('id', 'uid', 'jenis', 'student_id')
                ->doesntHave('pinjams')
                ->get(),

            'santri' => Inertia::lazy(
                fn () => Student::with(['devices' => fn ($query) => $query->withStatus()])
                    ->select('id', 'nama')
                    ->firstWhere('uid', $request->uid)
            ),

            'daftar' => Pinjam::with(['student:id,nama', 'device:id,jenis', 'user:id,nama'])
                ->has('student')
                ->whereDate('created_at', now())
                ->orderByDesc('id')
                ->limit(4)
                ->get()
        ]);
    }

    public function kembali(Request $request)
    {
        return Inertia::render('Kembali', [
            'daftar' => Pinjam::with(['student:id,nama', 'device:id,jenis', 'user:id,nama'])
                ->has('student')
                ->withTrashed()
                ->whereDate('created_at', now())
                ->orderByDesc('id')
                ->limit(6)
                ->get()
                ->each
                ->append('status'),

            'siswa' => Student::whereHas('pinjams')->get(),
            'pinjam' => Inertia::lazy(
                fn () => Pinjam::with('device:id,uid,jenis')
                    ->whereRelation('student', 'uid', $request->uid)
                    ->select('id', 'dipinjam', 'device_id')
                    ->get()
            )
        ]);
    }

    public function riwayat(Request $request)
    {
        $request->start ??= date('Y-m-d');
        $request->end ??= date('Y-m-d');
        $request->status ??= 0;

        return Inertia::render('Riwayat', [
            'raks' => Rak::all(),
            'daftar' => Pinjam::with([
                'student:id,uid,nama',
                'device:id,uid,jenis,rak_id',
                'device.rak',
                'user:id,nama'
            ])
                ->has('student')
                ->when(
                    $request->cari,
                    fn ($query) => $query->whereHas(
                        'student',
                        fn ($query) => $query
                            ->where('nama', 'like', "%$request->cari%")
                            ->orWhere('uid', 'like', "%$request->cari%")

                    )
                )
                ->when(
                    $request->rak,
                    fn ($query) => $query->whereHas(
                        'device',
                        fn ($query) => $query->where('rak_id', $request->rak)
                    )
                )
                ->when(
                    $request->start,
                    fn ($query) => $query
                        ->whereDate('created_at', '>=', $request->start)
                        ->whereDate('created_at', '<=', $request->end)
                )
                ->when(
                    $request->status == 0,
                    fn ($query) => $query->withTrashed()
                )
                ->when(
                    $request->status == 'kembali',
                    fn ($query) => $query->onlyTrashed()
                )
                ->orderByDesc('id')
                ->get()
                ->each
                ->append('status'),

            'cari' => $request->cari,
            'start' => $request->start,
            'end' => $request->end,
            'rak' => $request->rak,
            'status' => $request->status,
        ]);
    }

    public function store(PinjamRequest $request)
    {
        $alert = $this::execute(
            try: fn () => Pinjam::create($request->input()),
            message: 'pinjam device'
        );

        return back()->with('alert', $alert);
    }

    public function delete(Pinjam $pinjam)
    {
        $alert = $this::execute(
            try: fn () => $pinjam->delete(),
            message: 'kembalikan device'
        );

        return back()->with('alert', $alert);
    }
}
