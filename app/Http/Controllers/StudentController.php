<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Device;
use App\Models\Student;
use App\Traits\HasTryCatch;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    use HasTryCatch;

    public function index(Request $request)
    {
        return Inertia::render('Siswa/SiswaDaftar', [
            'daftar' => Student::withCount('devices')
                ->where('uid', 'like', "%$request->cari%")
                ->orWhere('nama', 'like', "%$request->cari%")
                ->orderBy('nama')
                ->limit(20)
                ->get(),

            'cari' => $request->cari
        ]);
    }

    public function edit(Student $student)
    {
        return Inertia::render('Siswa/SiswaEdit', [
            'siswa' => $student
        ]);
    }

    public function assigne(Student $student)
    {
        return Inertia::render('Siswa/SiswaAssigne', [
            'siswa' => $student,
            'devices' => $student->devices()->with('rak')->get(),
            'daftar' => Device::select('id', 'uid', 'jenis')
                ->whereDoesntHave('student')
                ->get()
        ]);
    }

    public function create()
    {
        return Inertia::render('Siswa/SiswaTambah');
    }

    public function store(StudentRequest $request)
    {
        $alert = $this::execute(
            try: fn () => Student::create($request->input()),
            message: 'tambah siswa'
        );

        return back()->with('alert', $alert);
    }

    public function update(StudentRequest $request)
    {
        $alert = $this::execute(
            try: fn () => Student::where('id', $request->id)->update($request->input()),
            message: 'update siswa'
        );

        return back()->with('alert', $alert);
    }

    public function destroy(Student $student)
    {
        $alert = $this::execute(
            try: fn () => $student->delete(),
            message: 'hapus siswa'
        );

        return back()->with('alert', $alert);
    }

    public function link(Request $request)
    {
        $find = Device::firstWhere('uid', $request->uid);

        $alert = $this::execute(
            try: fn () => $find->update(['student_id' => $request->siswa]),
            message: 'link device'
        );

        return back()->with('alert', $alert);
    }

    public function unlink(Device $device)
    {
        $alert = $this::execute(
            try: fn () => $device->update(['student_id' => null]),
            message: 'unlink device'
        );

        return back()->with('alert', $alert);
    }

    public function disable()
    {
        return Inertia::render('Siswa/SiswaBlokir', [
            'daftar' => Student::with([
                'latestPinjam' => fn ($query) => $query
                    ->with(['user:id,nama', 'device:id,uid,jenis'])
            ])
                ->where('is_block', 1)
                ->orderBy('nama')
                ->get()
        ]);
    }

    public function block(Student $student)
    {
        $alert = $this::execute(
            try: fn () => $student->update(['is_block' => 1]),
            message: 'blokir siswa'
        );

        return back()->with('alert', $alert);
    }

    public function unblock(Student $student)
    {
        $alert = $this::execute(
            try: fn () => $student->update(['is_block' => null]),
            message: 'unblock siswa'
        );

        return back()->with('alert', $alert);
    }
}
