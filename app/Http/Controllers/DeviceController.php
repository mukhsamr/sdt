<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeviceRequest;
use App\Models\Device;
use App\Models\Rak;
use App\Traits\HasTryCatch;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DeviceController extends Controller
{
    use HasTryCatch;

    public function index(Request $request)
    {
        return Inertia::render('Device/DeviceDaftar', [
            'daftar' => Device::with([
                'student' => fn ($query) => $query->select('id', 'nama')->withoutGlobalScopes(),
                'rak'
            ])
                ->where('uid', 'like', "%$request->cari%")
                ->orWhere('jenis', 'like', "%$request->cari%")
                ->orderBy('rak_id')
                ->limit(20)
                ->get()
        ]);
    }

    public function edit(Device $device)
    {
        return Inertia::render('Device/DeviceEdit', [
            'device' => $device->load('rak'),
            'raks' => Rak::where('tipe', session('tipe'))->get()
        ]);
    }

    public function create()
    {
        return Inertia::render('Device/DeviceTambah', [
            'raks' => Rak::where('tipe', session('tipe'))->get()
        ]);
    }

    public function store(DeviceRequest $request)
    {
        $alert = $this::execute(
            try: fn () => Device::create($request->input()),
            message: 'tambah device'
        );

        return back()->with('alert', $alert);
    }

    public function update(DeviceRequest $request)
    {
        $alert = $this::execute(
            try: fn () => Device::where('id', $request->id)->update($request->input()),
            message: 'update device'
        );

        return back()->with('alert', $alert);
    }

    public function destroy(Device $device)
    {
        $alert = $this::execute(
            try: fn () => $device->delete(),
            message: 'hapus device'
        );

        return back()->with('alert', $alert);
    }
}
