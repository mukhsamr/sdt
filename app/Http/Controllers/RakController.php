<?php

namespace App\Http\Controllers;

use App\Http\Requests\RakRequest;
use App\Models\Device;
use App\Models\Rak;
use App\Traits\HasTryCatch;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RakController extends Controller
{
    use HasTryCatch;

    public function index()
    {
        return Inertia::render('Rak/RakDaftar', [
            'daftar' => Rak::withCount('device')->orderBy('rak')->get()
        ]);
    }

    public function store(RakRequest $request)
    {
        $alert = $this::execute(
            try: fn () => Rak::create($request->input()),
            message: 'tambah rak'
        );

        return back()->with('alert', $alert);
    }

    public function update(RakRequest $request)
    {
        $alert = $this::execute(
            try: fn () => Rak::where('id', $request->id)->update($request->input()),
            message: 'update rak'
        );

        return back()->with('alert', $alert);
    }

    public function destroy(Rak $rak)
    {
        $alert = $this::execute(
            try: fn () => $rak->delete(),
            message: 'hapus rak'
        );
        return back()->with('alert', $alert);
    }

    public function assigne(Rak $rak)
    {
        return Inertia::render('Rak/RakAssigne', [
            'rak' => $rak,
            'devices' => $rak->device()
                ->select('id', 'jenis', 'student_id')
                ->with([
                    'student' => fn ($query) => $query->select('id', 'nama')->withoutGlobalScopes()
                ])
                ->get(),

            'daftar' => Device::select('id', 'uid', 'jenis')
                ->whereNull('rak_id')
                ->get()
        ]);
    }

    public function link(Request $request)
    {
        $alert = $this::execute(
            try: fn () => Device::firstWhere('uid', $request->uid)->update(['rak_id' => $request->rak_id]),
            message: 'link device'
        );

        return back()->with('alert', $alert);
    }

    public function unlink(Device $device)
    {
        $alert = $this::execute(
            try: fn () => $device->update(['rak_id' => null]),
            message: 'unlink device'
        );

        return back()->with('alert', $alert);
    }
}
